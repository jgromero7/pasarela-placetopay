<?php

namespace App\Billing;

use Illuminate\Http\Request;

class TransactionRequest
{
    public $bankCode;
    public $bankInterface;
    public $returnURL;
    public $reference;
    public $description;
    public $language = 'ES';
    public $currency = 'COP';
    public $totalAmount;
    public $taxAmount;
    public $devolutionBase;
    public $tipAmount;
    public $payer;
    public $buyer;
    public $shipping;
    public $ipAddress;
    public $userAgent;
    public $additionalData;

    /**
     * Creates a transaction object using an Order an a Request
     *
     * @param \App\Order $order
     * @param \Illuminate\Http\Request $request
     * @return \App\Billing\TransactionRequest
     */
    static public function fromOrder($order, $request) {
        $transaction = new self();

        $transaction->bankCode = $request->bank_code;
        $transaction->bankInterface = $request->person_type;
        $transaction->reference = $order->reference;
        $transaction->description = $order->description;
        $transaction->totalAmount = $order->amount;
        $transaction->payer = Person::fromRequest($order->email, $request);
        $transaction->ipAddress = $request->ip();
        $transaction->userAgent = $request->userAgent();

        return $transaction;
    }

}