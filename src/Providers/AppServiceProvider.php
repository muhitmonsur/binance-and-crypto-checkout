<?php

namespace Payerurl\Providers;

use Illuminate\Support\ServiceProvider;
use Payerurl\Payerurl;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/payerurl.php', 'payerurl');

        $this->app->bind('payerurl', function () {
            return new Payerurl();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/payerurl.php' => config_path('payerurl.php'),
        ], 'config');
    }
}
