<?php

namespace App\PlaceToPay;

class Resource extends Client
{
    /** @var \App\PlaceToPay */
    private $placeToPay;

    /**
     * Resource constructor.
     *
     * @param $placeToPay
     */
    public function __construct($placeToPay)
    {
        $this->placeToPay = $placeToPay;
    }

    /**
     * Provides authentication for the requests
     *
     * @return \App\PlaceToPay\Authentication
     */
    public function auth()
    {
        return new Authentication([
            'login' => $this->placeToPay->login,
            'secretKey' => $this->placeToPay->secretKey,
            'api' => $this->placeToPay->api,
        ]);
    }
}