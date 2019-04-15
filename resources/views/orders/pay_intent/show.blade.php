<div class="row">
    <div class="col-sm-6">
        <p>
            <b>Transacción:</b> {{ $payIntent->requestId }}
        </p>
        <p>
            <b>Estado:</b> @include('orders.pay_intent.status_label')
            
        </p>
    </div>
    <div class="col-sm-6">
        <p><b>Fecha:</b> {{ $payIntent->created_at->toDateString() }}</p>
    </div>
</div>
<p class="text-center">
    <i></i>
</p>