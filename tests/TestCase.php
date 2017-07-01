<?php

use Orchestra\Database\ConsoleServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->loadLaravelMigrations(['--database' => 'testing']);

        $this->loadMigrationsFrom([
            '--database' => 'testing',
            '--realpath' => realpath(__DIR__.'/../src/migrations'),
        ]);

        $this->user_model = app(config('taxes.user'));
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

        $app['config']->set('taxes.user', Illuminate\Foundation\Auth\User::class);

        $app['config']->set('taxes.tables.governmental_unit_areas', 'governmental_unit_areas');
        $app['config']->set('taxes.tables.tax_areas', 'tax_areas');
        $app['config']->set('taxes.tables.tax_information', 'tax_information');
        $app['config']->set('taxes.tables.us.federal_income_tax_information', 'federal_income_tax_information');
        $app['config']->set('taxes.tables.us.alabama.alabama_income_tax_information', 'alabama_income_tax_information');
    }

    protected function getPackageProviders($app)
    {
        return [
            ConsoleServiceProvider::class,
        ];
    }
}
