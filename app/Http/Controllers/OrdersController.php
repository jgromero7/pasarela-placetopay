<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Billing\PaymentGateway;
use App\Product;
use App\Order;
use App\PayIntent;
use Illuminate\Support\Facades\Cache;

class OrdersController extends Controller
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
        return view('orders.index')->with([
            'orders' => Order::with('payIntent')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            'email' => 'required|string|email|max:255',
            'quantity' => 'required|integer|min:1|max:500'
        ]);
        $order = Order::create([
            'email' => $data['email'],
            'quantity' => $data['quantity'],
            'amount' => $data['quantity'] * Product::price(),
            'description' => Product::description(),
            'reference' => str_random(15),
        ]);
        return redirect()
            ->route("orders.payments.create", $order);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order, PayIntent $payIntent)
    {
        $response = $this->paymentGateway->getTransaction($order->id);

        $payIntentId = Cache::get('payIntentId');

        $payIntent = PayIntent::find($payIntentId);
        $payIntent->status = $response['status']['status'];
        $payIntent->save();

        return view('orders.show')->with([
            'order' => $order,
        ]);
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
