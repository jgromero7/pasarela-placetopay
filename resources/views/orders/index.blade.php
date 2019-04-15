@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1 class="page-header">Ordenes realizadas</h1>
                <div class="panel panel-default">
                    <table class="table">
                        <thead>

                        <tr>
                            <th>ID</th>
                            <th>Referencia</th>
                            <th>Valor</th>
                            <th>Email</th>
                            <th>Estado</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>
                                    <a href="{{route('orders.show', $order)}}">{{$order->id}}</a>
                                </td>
                                <td>{{$order->reference}}</td>
                                <td>{{$order->formattedAmount()}}</td>
                                <td>{{$order->email}}</td>
                                <td>@include('orders.pay_intent.status_label', ['payIntent' => $order->payIntent])</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection