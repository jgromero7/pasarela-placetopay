<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payIntents()
    {
        return $this->hasMany(PayIntent::class);
    }
    /**
     * Determine is the order has old payments, it means more than the latest.
     *
     * @return bool
     */
    public function hasOldPayIntents()
    {
        return $this->payIntents->count() > 1;
    }
    /**
     * The old payment attempts, it splices the latest one.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function oldPayIntents()
    {
        return $this->payIntents->sortByDesc('created_at')->splice(1);
    }
    /**
     * The latest payment attempt
     *
     * @return \Illuminate\Database\Query\Builder|static
     */
    public function payIntent()
    {
        return $this->hasOne(PayIntent::class)->latest();
    }
    /**
     * Determine if the order has a payment attempt.
     *
     * @return bool
     */
    public function hasPayIntent()
    {
        return !!$this->payIntent;
    }
    /**
     * Determine if the order is missing the payment attempt
     *
     * @return bool
     */
    public function isMissingPayment()
    {
        return !$this->hasPayIntent();
    }
    /**
     * Formatted amount, using COP format.
     *
     * @return string
     */
    public function formattedAmount()
    {
        return number_format($this->amount, 0, '', '.');
    }
    /**
     * Uses the payment attempt to check if there is a need to synchronize it.
     *
     * @return bool
     */
    public function needsToSyncPayment()
    {
        return !!optional($this->payInent)->needsSyncTransaction();
    }
    /**
     * Wrapper method to synchronize the payment attempt.
     *
     * @param $paymentGateway
     * @return $this
     */
    public function syncPayment($paymentGateway)
    {
        optional($this->payIntent)->syncTransaction($paymentGateway);
        $this->load('payIntent');
        return $this;
    }
    public function isFailed()
    {
        return optional($this->payIntent)->isFailed();
    }
    public function isOk()
    {
        return optional($this->payIntent)->isOk();
    }
    public function isApproved()
    {
        return optional($this->payIntent)->isApproved();
    }
    public function isApprovedPartial()
    {
        return optional($this->payIntent)->isApprovedPartial();
    }
    public function isDeclined()
    {
        return optional($this->payIntent)->isDeclined();
    }
    public function isPending()
    {
        return optional($this->payIntent)->isPending();
    }
    public function isPendingValidation()
    {
        return optional($this->payIntent)->isPendingValidation();
    }
    public function isRefunded()
    {
        return optional($this->payIntent)->isRefunded();
    }

}
