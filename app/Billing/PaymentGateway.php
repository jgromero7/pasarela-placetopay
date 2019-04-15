<?php

namespace App\Billing;

interface PaymentGateway
{
    /**
     * @param $data
     * @param $params
     * @return object
     */
    public function createTransaction($data, $buyer, $orderID, $request);

    /**
     * @param $id
     * @return object
     */
    public function getTransaction($id);
}