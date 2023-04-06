<?php

namespace BrankoDragovic\Currency\ServiceProvider;

use BrankoDragovic\Currency\Currency;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class CurrencyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {


    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration

        $this->app->bind('currency', function () {
            return new Currency(new Client());
        });
    }
}
