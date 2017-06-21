<?php

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Orchestra\Database\ConsoleServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->loadMigrationsFrom([
            '--database' => 'testing',
            '--realpath' => realpath(__DIR__.'/../src/migrations'),
        ]);
    }

    protected function addCommand($command)
    {
        $this->app[Kernel::class]->registerCommand(app($command));
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testing');

        $app['config']->set('database.connections.testing', [
            'driver' => 'pgsql',
            'host' => env('TEST_DB_HOST'),
            'port' => env('TEST_DB_PORT', 5432),
            'database' => env('TEST_DB_DATABASE'),
            'username' => env('PG_USER', env('TEST_DB_USERNAME')),
            'password' => env('PG_PASSWORD', env('TEST_DB_PASSWORD')),
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
        ]);

        $app['config']->set('taxes.governmental_unit_areas', 'governmental_unit_areas');
        $app['config']->set('taxes.tax_areas', 'tax_areas');
    }

    protected function getPackageProviders($app)
    {
        return [
            ConsoleServiceProvider::class,
        ];
    }
}
