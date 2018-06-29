<?php
namespace Isurindu\WebxpayLaravel;

use Illuminate\Support\ServiceProvider;
use Isurindu\WebxpayLaravel\WebxpayPaymentManager;

class WebxpayServiceProvider extends ServiceProvider
{
    public function boot()
    {
        include('includes/Math/BigInteger.php');
        include('includes/Crypt/RSA.php');
        $this->publishes([
            __DIR__.'/config/webxpay.php' => config_path('webxpay.php'),
        ]);

        $this->loadViewsFrom(__DIR__.'/views', 'webxpay');

        $this->publishes([
            __DIR__.'/views' => resource_path('views/vendor/webxpay'),
        ]);


        $this->app->singleton('webxpay', function ($app) {
            return new WebxpayPaymentManager;
        });
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/webxpay.php',
            'webxpay'
        );
    }
}
