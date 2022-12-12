<?php

namespace CryptoPay\Binancepay;

use CryptoPay\Binancepay\GatewayClient\GatewayClient;
use CryptoPay\Binancepay\GatewayClientConfig\ClientConfig;
use Exception;

class BinancePay
{
    private ClientConfig $clientConfig;

    private array $response = [];

    /**
     * Terminal type of which the merchant service applies to. Valid values are:
     * APP:
     * The client-side terminal type is a mobile application.
     *
     * WEB:
     * The client-side terminal type is a website that is opened via a PC browser.
     *
     * WAP:
     * The client-side terminal type is an HTML page that is opened via a mobile browser.
     *
     * MINI_PROGRAM:
     * The terminal type of the merchant side is a mini program on the mobile phone.
     *
     * OTHERS:
     * other undefined type
     *
     */
    private string $terminalType;

    /**
     * order currency in upper case.
     * only "BUSD","USDT","MBOX" can be accepted, fiat NOT supported.
     */
    private string $currency;

    /**
     * 0000: Electronics & Computers
     * 1000: Books, Music & Movies
     * 2000: Home, Garden & Tools
     * 3000: Clothes, Shoes & Bags
     * 4000: Toys, Kids & Baby
     * 5000: Automotive & Accessories
     * 6000: Game & Recharge
     * 7000: Entertainament & Collection
     * 8000: Jewelry
     * 9000: Domestic service
     * A000: Beauty care
     * B000: Pharmacy
     * C000: Sports & Outdoors
     * D000: Food, Grocery & Health products
     * E000: Pet supplies
     * F000: Industry & Science
     * Z000: Others
     */
    private string $goodsCategory;

    /**
     * the type of the goods for the order:
     * 01: Tangible Goods
     * 02: Virtual Goods
     */
    private string $goodsType;

    /**
     * @throws Exception
     */
    public function __construct(string $endpoint)
    {
        $this->clientConfig = new ClientConfig();
        $this->clientConfig->setServiceEndpoint(env('BINANCE_SERVICE_ENDPOINT', '') . "/" . $endpoint);
        $this->clientConfig->setBinancePayKey(env('BINANCE_MERCHANT_API_KEY', ''));
        $this->clientConfig->setBinancePaySecret(env('BINANCE_MERCHANT_SECRET_KEY', ''));

        $this->terminalType = env('BINANCE_TERMINAL_TYPE', 'WEB');
        $this->currency = env('BINANCE_CURRENCY', "USDT");
        $this->goodsCategory = env('BINANCE_GOODS_CATEGORY', "Z000");

        $this->goodsType = env('BINANCE_GOODS_TYPE', "02");
    }

    public function createOrder($data)
    {
        try {
            $client = new GatewayClient($this->clientConfig);

            $request = array(
                "env" => array(
                    "terminalType" => $this->terminalType
                ),
                "merchantTradeNo" => $data['passcode_id'],
                "orderAmount" => $data['order_amount'],
                "currency" => $this->currency,
                "goods" => array(
                    "goodsType" => $this->goodsType,
                    "goodsCategory" => $this->goodsCategory,
                    "referenceGoodsId" => $data['package_id'],
                    "goodsName" => $data['goods_name'],
                    "goodsDetail" => $data['goods_detail'] ?? ''
                )
            );
            return $client->init($request);
        } catch (Exception $e) {

            $this->response['status'] = false;
            $this->response['msg'] = $e->getMessage();

            return $this->response;
        }
    }
}