@if(!$order->hasPayIntent())
    El pago no se ha iniciado, puedes
    <a href="{{ route('orders.payments.create', $order) }}">iniciar un Pago</a>
@elseif($order->isFailed())
    El pago de esta orden ha falllado, puedes
    <a href="{{ route('orders.payments.create', $order) }}">intentarlo de nuevo</a>
@elseif($order->isOk())
    El pago no se ha iniciado, puedes
    <a href="{{ route('orders.payments.create', $order) }}">iniciar un Pago</a>
@elseif($order->isApproved())
    El pago de esta orden esta Aprobado
@elseif($order->isApprovedPartial())
    El pago de esta orden esta Aprobado de manera Parcial
@elseif($order->isDeclined())
    Se ha desistido de pagar esta order, puedes
    <a href="{{ route('orders.payments.create', $order) }}">intentarlo de nuevo</a>
@elseif($order->isPending())
    La confirmación de el pago está pendiente,  Intenta más tarde
@elseif($order->isPendingValidation())
    La confirmación de el pago está pendiente por validación
@elseif($order->isRefunded())
    El pago de esta orden esta Reintegrado
@endif
