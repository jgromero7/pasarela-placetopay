<?php

namespace App\PlaceToPay;

class PlaceToPay
{

    /** @var  */
    public $login;

    /** @var  */
    public $secretKey;

    /** @var  */
    public $api;

    /**
     * PlaceToPay constructor.
     *
     * @param $options
     * @throws \Exception
     */
    public function __construct($options)
    {
        $this->login = $options['login'];
        $this->secretKey = $options['secretKey'];
        $this->api = $options['api'];

        if (!$this->login && !$this->secretKey && !$this->api) {
            throw new \Exception('Not Login or TranKey provided');
        }
    }
}