<?php

namespace Explicador\E2PaymentsPhpSdk\Providers;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Service provider
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/e2payments.php', config_path('e2payments.php'),
        ]);

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/e2payments.php', 'e2payments'
        );

        $this->app->bind('\Explicador\E2PaymentsPhpSdk\Mpesa', function ($app) {

            $mpesa =  new \Explicador\E2PaymentsPhpSdk\Mpesa();

            $mpesa->setClientSecret(config('e2payments.client_secret'));
            $mpesa->setClientId(config('e2payments.client_id'));//test

            $mpesa->setWalletId(config('e2payments.walled_id'));

            return $mpesa;
        });
    }
}
