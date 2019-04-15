<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        Schema::defaultStringLength(191);

        $this->app->bind(\App\Billing\PlaceToPayPaymentGateway::class, function () {
            return new \App\Billing\PlaceToPayPaymentGateway([
                'login' => config('services.placetopay.login'),
                'secretKey' => config('services.placetopay.secretKey'),
                'api' => config('services.placetopay.api')
            ]);
        });
        $this->app->bind(\App\Billing\PaymentGateway::class, \App\Billing\PlaceToPayPaymentGateway::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
