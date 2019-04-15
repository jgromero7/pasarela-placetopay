<?php

namespace App\Http\Controllers;

use App\Billing\PaymentGateway;
use App\Billing\TransactionRequest;
use App\Order;
use App\PayIntent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PayIntentController extends Controller
{

    public $paymentGateway;
    
    public function __construct(PaymentGateway $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Order $order)
    {
        if ($order->isApproved() || $order->isPending()){
            return redirect(route('orders.show', $order));
        }
        return view('pay-intent.create')->with([
            'order' => $order
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Order $order, Request $request)
    {
        $this->validate($request,[
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'document_type' => 'required|string|in:CC,CE,TI,PPN,NIT,SSN',
            'document' => 'required|numeric',
        ]);
               
        $data = array(
            'reference' => $order->reference, 
            'description' => $order->description, 
            'amount' => array(
                'currency' => 'COP',
                'total' => $order->amount
            )
        );

        $buyer = array(
            'document' => $request['document'], 
            'documentType' => $request['document_type'], 
            'name' => $request['first_name'],
            'surname' => $request['last_name'],
            'email' => $order->email,
        );

        $response = $this->paymentGateway->createTransaction($data, $buyer, $order->id, $request);

        $payIntent = PayIntent::create([
            'order_id' => $order->id,
            'status' =>  $response["status"]['status'],
            'request_id' => $response["requestId"],
            'response' => json_encode($response)
        ]);

        if ( $response["status"]['status'] == 'OK' ) {
            Cache::forget('payIntentId');
            Cache::add('payIntentId', $payIntent->id);
            return redirect($response["processUrl"]);
        }

        return redirect(route('orders.show', $order));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
