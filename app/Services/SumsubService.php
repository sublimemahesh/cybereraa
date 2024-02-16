<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Utils;
use JsonException;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

class SumsubService
{

    protected Client $guzzleClient;

    protected string $appToken;

    protected string $secretKey;

    protected string $webhookSecretKey;

    public function __construct()
    {
        $this->appToken = config('sumsub.app_token');
        $this->secretKey = config('sumsub.secret_key');
        $this->webhookSecretKey = config('sumsub.webhook_secret_key');
        $this->guzzleClient = new Client(['base_uri' => config('sumsub.base_url')]);
    }

    /**
     * https://developers.sumsub.com/api-reference/#creating-an-applicant
     *
     * @param string $externalUserId
     * @param string $levelName
     * @return string Applicant ID
     * @throws RuntimeException
     * @throws JsonException
     */
    public function createApplicant(string $externalUserId, string $levelName): string
    {
        $requestBody = compact('externalUserId');
        $url = '/resources/applicants?' . http_build_query(compact('levelName'));

        try {

            $request = (new Request('POST', $url))
                ->withHeader('Content-Type', 'application/json')
                ->withBody(Utils::streamFor(json_encode($requestBody, JSON_THROW_ON_ERROR)));

            $response = $this->sendRequest($request);
            $body = $this->parseBody($response);

            return $body['id'];
        } catch (GuzzleException $e) {
            throw new RuntimeException('Error occurred during the request', 0, $e);
        }
    }

    /**
     * https://developers.sumsub.com/api-reference/#adding-an-id-document
     *
     * @param string $applicantId
     * @param string $filePath
     * @param array $metadata
     * @return string Image ID
     * @throws RuntimeException
     * @throws JsonException
     */
    public function addDocument(string $applicantId, string $filePath, array $metadata): string
    {
        $multipart = new MultipartStream([
            [
                'name' => 'metadata',
                'contents' => json_encode($metadata, JSON_THROW_ON_ERROR)
            ],
            [
                'name' => 'content',
                'contents' => fopen($filePath, 'rb')
            ],
        ]);

        $url = '/resources/applicants/' . urlencode($applicantId) . '/info/idDoc';

        try {
            $request = new Request('POST', $url, body: $multipart);
            //->withBody($multipart);

            $response = $this->sendRequest($request);
            return $response->getHeader('X-Image-Id')[0] ?? '';
        } catch (GuzzleException $e) {
            throw new RuntimeException('Error occurred during the request', 0, $e);
        }
    }

    /**
     * https://developers.sumsub.com/api-reference/#getting-applicant-review-status
     *
     * @param string $applicantId
     * @return array
     * @throws JsonException
     * @throws RuntimeException
     */
    public function getApplicantReviewStatus(string $applicantId): array
    {

        $url = '/resources/applicants/' . urlencode($applicantId) . '/status';
        $request = new Request('GET', $url);

        $response = $this->sendRequest($request);
        return $this->parseBody($response);

    }

    /**
     * https://developers.sumsub.com/api-reference/#getting-applicant-verification-steps-status
     *
     * @param string $applicantId
     * @return array
     * @throws JsonException
     * @throws RuntimeException
     */
    public function getApplicantVerificationStepsStatus(string $applicantId): array
    {

        $url = '/resources/applicants/' . urlencode($applicantId) . '/requiredIdDocsStatus';
        $request = new Request('GET', $url);

        $response = $this->sendRequest($request);
        return $this->parseBody($response);

    }

    /**
     * https://developers.sumsub.com/api-reference/#getting-applicant-data
     *
     * @param string $applicantId
     * @return array
     * @throws JsonException
     * @throws RuntimeException
     */
    public function getApplicantData(string $applicantId): array
    {

        $url = '/resources/applicants/' . urlencode($applicantId) . '/one';
        $request = new Request('GET', $url);

        $response = $this->sendRequest($request);
        return $this->parseBody($response);

    }

    /**
     * https://developers.sumsub.com/api-reference/#getting-document-images
     *
     * @param string $inspectionId
     * @param string $imageId
     * @return array
     * @throws JsonException
     */
    public function getApplicantDocumentImage(string $inspectionId, string $imageId): array
    {

        $url = '/resources/inspections/' . urlencode($inspectionId) . '/resources/' . urlencode($imageId);
        $request = new Request('GET', $url);

        $response = $this->sendRequest($request);
        return $this->parseBody($response); // TODO: test headers and response

    }

    /**
     * https://developers.sumsub.com/api-reference/#access-tokens-for-sdks
     *
     * @param string $externalUserId
     * @param string $levelName
     * @return array
     * @throws RuntimeException
     * @throws JsonException
     */
    public function getAccessToken(string $externalUserId, string $levelName): array
    {
        $url = '/resources/accessTokens?' . http_build_query(['userId' => $externalUserId, 'levelName' => $levelName]);
        $request = new Request('POST', $url);

        $response = $this->sendRequest($request);
        return $this->parseBody($response);
    }

    /**
     * @param RequestInterface|MessageInterface $request
     * @return ResponseInterface
     */
    protected function sendRequest(RequestInterface|MessageInterface $request): ResponseInterface
    {
        $now = time();
        $request = $request->withHeader('X-App-Token', $this->appToken)
            ->withHeader('X-App-Access-Sig', $this->createSignature($request, $now))
            ->withHeader('X-App-Access-Ts', $now);

        \Log::channel('sumsub')->info("Request sending: {$request->getUri()}");

        try {
            $response = $this->guzzleClient->send($request);
            if ($response->getStatusCode() !== 200 && $response->getStatusCode() !== 201) {
                // https://developers.sumsub.com/api-reference/#errors
                // If an unsuccessful answer is received, please log the value of the `correlationId` parameter.
                $error = 'Invalid status code received: ' . $response->getStatusCode() . '. Body: ' . $response->getBody();
                \Log::channel('sumsub')->error($error);
                throw new RuntimeException($error);
            }

            return $response;
        } catch (GuzzleException $e) {
            $error = "Error occurred during the request: {$e->getMessage()}";
            \Log::channel('sumsub')->error($error);
            throw new RuntimeException($error, 0, $e);
        }
    }

    protected function createSignature(RequestInterface $request, int $ts): string
    {
        return hash_hmac('sha256', $ts . strtoupper($request->getMethod()) . $request->getUri() . $request->getBody(), $this->secretKey);
    }

    /**
     * @throws JsonException
     */
    protected function parseBody(ResponseInterface $response): array
    {
        $data = (string)$response->getBody();
        $json = json_decode($data, true, JSON_THROW_ON_ERROR, JSON_THROW_ON_ERROR);
        if (!is_array($json)) {
            \Log::channel('sumsub')->error('Invalid response received: ' . $data);
            throw new RuntimeException('Invalid response received: ' . $data);
        }
        \Log::channel('sumsub')->info('Response received: ', $json);

        return $json;
    }

    public function validateWebHook(\Illuminate\Http\Request $request): bool
    {
        $algo = match ($request->headers->get('X-Payload-Digest-Alg')) {
            'HMAC_SHA1_HEX' => 'sha1',
            'HMAC_SHA256_HEX' => 'sha256',
            'HMAC_SHA512_HEX' => 'sha512',
            default => throw new \RuntimeException('Unsupported algorithm'),
        };

        $payload_digest = $request->headers->get('X-Payload-Digest');
        $payload = $request->getContent();


        // TODO: use inspectionCallbacks or calculate using hash_hmac
//        $url = '/resources/inspectionCallbacks/testDigest?' . http_build_query(['secretKey' => $this->>webhookSecretKey, 'digestAlg' => $request->headers->get('X-Payload-Digest-Alg')]);
//        $http = (new Request('POST', $url, body: $payload));
//
//        $response = $this->sendRequest($http);
//        $inspectionCallbacks_digest = $this->parseBody($response)['digest'];
//
//        \Log::channel('sumsub')->info("inspectionCallbacks_digest: " . $inspectionCallbacks_digest);
//        \Log::channel('sumsub')->info("payload_digest: {$payload_digest}: ");
//        \Log::channel('sumsub')->info("calculated_digest: {$calculated_digest}: ");
//        \Log::channel('sumsub')->info('payload: ' . $payload);

        $calculated_digest = hash_hmac(
            $algo,
            $payload,
            $this->webhookSecretKey
        );

//        if ($payload_digest !== $inspectionCallbacks_digest) {
        if ($payload_digest !== $calculated_digest) {
            \Log::channel('sumsub')->error('Webhook sumsub sign failed: ' . $payload);
            return false;
//            throw new UnauthorizedException('Webhook sumsub sign ' . $content);
        }

        return true;
    }
}
