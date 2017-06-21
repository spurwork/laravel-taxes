<?php

namespace Appleton\Taxes\Providers;

use Illuminate\Support\ServiceProvider;
use Appleton\Taxes\Taxes;
use Appleton\Taxes\Commands\ImportCommand;

class TaxServiceProvider extends ServiceProvider
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

        if ($this->app->runningInConsole()) {
            $this->commands([ImportCommand::class]);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'taxes');

        $this->app->singleton('taxes', function ($app) {
            $taxes = new Taxes($app);
            return $taxes;
        });
    }
}
