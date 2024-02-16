<?php

namespace App\Http\Controllers;

use App\Jobs\SumSubListener;
use App\Models\User;
use App\Services\SumsubService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

class SumsubClientController extends Controller
{
    protected SumsubService $sumSubService;

    public function __construct(SumsubService $sumSubService)
    {
        $this->sumSubService = $sumSubService;
    }

    public function getAccessToken(Request $request): JsonResponse|null
    {

        $externalUserId = \Auth::user()->username;
        $levelName = config('sumsub.applicant_level');
//        $levelName = $request->input('levelName');
        $ttlInSecs = $request->input('ttlInSecs');

        \Log::channel('sumsub')->notice("AccessTokenRequested: {$externalUserId}");

        try {
            $accessToken = $this->sumSubService->getAccessToken($externalUserId, $levelName);
            return response()->json($accessToken);
        } catch (RuntimeException|\JsonException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @throws \JsonException
     */
    public function webhook(Request $request)
    {
        $webhookSenderVerified = $this->sumSubService->validateWebHook($request);

        if ($webhookSenderVerified) {
            \Log::channel('sumsub')->info('SumsubClientController webhook: ', $request->all());

            $applicantData = $this->sumSubService->getApplicantData($request->get('applicantId'));

            $user = User::where('username', $request->get('externalUserId'))->first();

            $user->profile()->update([
                'sumsub_kyc_response' => json_encode($request->all(), JSON_THROW_ON_ERROR),
                'sumsub_kyc_applicant_data' => json_encode($applicantData, JSON_THROW_ON_ERROR),
            ]);

            if ($request->get('type') === 'applicantReviewed') {
                try {
                    \DB::transaction(function () use ($request, $applicantData, $user) {
                        $applicantVerificationSteps = $this->sumSubService->getApplicantVerificationStepsStatus($request->get('applicantId'));

                        $idDocSetType = match ($applicantVerificationSteps['IDENTITY']['idDocType']) {
                            'DRIVERS' => 'driving_lc_number',
                            'ID_CARD' => 'nic',
                            'PASSPORT' => 'passport_number',
                            default => null,
                        };

                        $idDocVerifyColumn = match ($idDocSetType) {
                            'nic' => 'nic_verified_at',
                            'driving_lc_number' => 'driving_lc_verified_at',
                            'passport_number' => 'passport_verified_at',
                            default => null,
                        };

                        if ($request->get('reviewResult')['reviewAnswer'] === 'GREEN') {
                            $idDocSetTypeInfo = \Arr::where($applicantData['info']['idDocs'], fn($arr) => $arr['idDocType'] === $applicantVerificationSteps['IDENTITY']['idDocType']);
                            $idDocSetTypeInfo = \Arr::first($idDocSetTypeInfo);

                            // \Log::warning('idDocSetTypeInfo', $idDocSetTypeInfo);
                            $user->profile()->update([
                                $idDocSetType => $idDocSetTypeInfo['number'] ?? null,
                                $idDocVerifyColumn => Carbon::parse($applicantData['review']['reviewDate'])
                            ]);
                        }

                        if ($request->get('reviewResult')['reviewAnswer'] === 'RED') {
                            $user->profile()->update([
                                'nic_verified_at' => NULL,
                                'driving_lc_verified_at' => NULL,
                                'passport_verified_at' => NULL,
                            ]);
                        }
                    });
                } catch (\Exception $e) {

                }
            }

            dispatch(new SumSubListener($request->all(), $user));

            return response()->json(['success' => true,], 200);
        }
        return response()->json(['success' => false,], Response::HTTP_UNAUTHORIZED);
    }
}
