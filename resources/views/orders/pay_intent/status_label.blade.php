@if(is_null($payIntent))
    <span class="label label-info">En espera</span>
@elseif($payIntent->isFailed())
    <span class="label label-danger">{{ $payIntent->readable_status }}</span>
@elseif($payIntent->isOk())
    <span class="label label-info">{{ $payIntent->readable_status }}</span>
@elseif($payIntent->isApproved())
    <span class="label label-success">{{ $payIntent->readable_status }}</span>
@elseif($payIntent->isApprovedPartial())
    <span class="label label-success">{{ $payIntent->readable_status }}</span>
@elseif($payIntent->isDeclined())
    <span class="label label-primary">{{ $payIntent->readable_status }}</span>
@elseif($payIntent->isPending())
    <span class="label label-warning">{{ $payIntent->readable_status }}</span>
@elseif($payIntent->isPendingValidation())
    <span class="label label-warning">{{ $payIntent->readable_status }}</span>
@elseif($payIntent->isRefunded())
    <span class="label label-warning">{{ $payIntent->readable_status }}</span>
@endif
