<?php

namespace App\Billing;

use App\PlaceToPay\PlaceToPay;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class PlaceToPayPaymentGateway implements PaymentGateway
{
    /**
     * @var \App\PlaceToPay\PlaceToPay
     */
    protected $placeToPay;

    /**
     * PlaceToPayPaymentGateway constructor.
     *
     * @param $config
     */
    public function __construct($config)
    {
        $this->placeToPay = new PlaceToPay([
            'login' => $config['login'],
            'secretKey' => $config['secretKey'],
            'api' => $config['api']
        ]);
    }

    /**
     * Creates a new Transaction using Placetopay PSE
     *
     * @param $data
     * @param array $params
     * @return object
     * @throws \Exception
     */
    public function createTransaction($data = null, $buyer = null, $orderID = null, $request)
    {
        $client = new \GuzzleHttp\Client(['verify' => false]);
        $url = $this->placeToPay->api."api/session";

        $response = $client->post(
            $url, [ \GuzzleHttp\RequestOptions::JSON => $this->buildDataSend($data, $buyer, $orderID, $request) ],
            ['Content-Type' => 'application/json']
        );
        
        $responseJSON = json_decode($response->getBody(), true);

        Cache::forget('requestId');
        Cache::add('requestId', $responseJSON['requestId']);

        return $responseJSON;
    }

    /**
     * Gets a transaction from the Placetopay WS
     *
     * @param $id
     * @return object
     * @throws \Exception
     */
    public function getTransaction($id)
    {
        $requestId = Cache::get('requestId');

        $url = $this->placeToPay->api."api/session/".$requestId;

        $client = new \GuzzleHttp\Client(['verify' => false]);
        $response = $client->post(
            $url, [ \GuzzleHttp\RequestOptions::JSON => array('auth' => $this->buildAuth()) ],
            ['Content-Type' => 'application/json']
        );
        // echo $response->getStatusCode();
        // 200
        $responseJSON = json_decode($response->getBody(), true);
        return $responseJSON;
    }

    /**
     * Gets a valid test code for the list of banks.
     *
     * @return array
     */
    public function buildDataSend($data = array(), $buyer = array(), $orderID = null, $request)
    {        
        return array(
            'auth' => $this->buildAuth(),
            'payment' => $data,
            'buyer' => $buyer,
            'expiration' => date("c",strtotime(date("d-m-Y")."+ 1 days")),
            "returnUrl" => route('orders.show', $orderID),
            "ipAddress" => $request->ip(),
            "userAgent" => $request->userAgent(),
        );
    }

    /**
     * Gets a valid test code for the list of banks.
     *
     * @return array
     */
    public function buildAuth()
    {
        $seed = date('c');

        if (function_exists('random_bytes')) {
            $nonce = bin2hex(random_bytes(16));
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $nonce = bin2hex(openssl_random_pseudo_bytes(16));
        } else {
            $nonce = mt_rand();
        }

        $nonceBase64 = base64_encode($nonce);

        $tranKey = base64_encode(sha1($nonce . $seed . $this->placeToPay->secretKey, true));
        
        return array(
            'login' => $this->placeToPay->login, 
            'seed' => $seed, 
            'nonce' => $nonceBase64, 
            'tranKey' => $tranKey
        );
    }
}