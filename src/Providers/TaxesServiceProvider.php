<?php

namespace Appleton\Taxes\Providers;

use Illuminate\Support\ServiceProvider;
use Appleton\Taxes\Classes\Taxes;

class TaxesServiceProvider extends ServiceProvider
{
    protected $defer = false;

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('taxes.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../migrations/' => database_path('/migrations')
        ], 'migrations');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'taxes');

        $this->app->register(TaxServiceProvider::class);
        $this->app->register(TaxInformationServiceProvider::class);

        $this->app->singleton('taxes', function ($app) {
            $taxes = new Taxes($app);
            return $taxes;
        });
    }
}
