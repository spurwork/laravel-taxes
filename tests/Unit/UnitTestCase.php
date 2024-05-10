<?php

namespace Appleton\Taxes\Tests\Unit;

use Appleton\Taxes\Providers\TaxesServiceProvider;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Orchestra\Testbench\TestCase as BaseTestCase;

class UnitTestCase extends BaseTestCase
{
    protected $user;

    public const DEFAULT_SHIFT_WAGES = 10000;
    public const DEFAULT_MINUTES_WORKED = 480;
    public const DEFAULT_POSITION = 1;

    use DatabaseTransactions, TestLocations, TestModelCreator;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = app(config('taxes.user'))->forceCreate([
            'name' => 'Test User',
            'email' => 'test@user.email',
            'password' => 'password',
        ]);
    }

    protected function getEnvironmentSetUp($app)
    {
        $app->useEnvironmentPath(__DIR__.'/../..');

        $app->bootstrapWith([LoadEnvironmentVariables::class]);

        parent::getEnvironmentSetUp($app);

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

        $app['config']->set('taxes.user', \Illuminate\Foundation\Auth\User::class);
        $app['config']->set('taxes.user_id', 'employee_id');

        $app['config']->set('taxes.tables.governmental_unit_areas', 'governmental_unit_areas');
        $app['config']->set('taxes.tables.tax_areas', 'tax_areas');
        $app['config']->set('taxes.tables.tax_information', 'tax_information');
        $app['config']->set('taxes.tables.us.federal_income_tax_information', 'federal_income_tax_information');
        $app['config']->set('taxes.tables.us.alabama.alabama_income_tax_information', 'alabama_income_tax_information');
        $app['config']->set('taxes.tables.us.arizona.arizona_income_tax_information', 'arizona_income_tax_information');
        $app['config']->set('taxes.tables.us.california.california_income_tax_information', 'california_income_tax_information');
        $app['config']->set('taxes.tables.us.colorado.colorado_income_tax_information', 'colorado_income_tax_information');
        $app['config']->set('taxes.tables.us.georgia.georgia_income_tax_information', 'georgia_income_tax_information');
        $app['config']->set('taxes.tables.us.illinois.illinois_income_tax_information', 'illinois_income_tax_information');
        $app['config']->set('taxes.tables.us.indiana.indiana_income_tax_information', 'indiana_income_tax_information');
        $app['config']->set('taxes.tables.us.kentucky.kentucky_income_tax_information', 'kentucky_income_tax_information');
        $app['config']->set('taxes.tables.us.louisiana.louisiana_income_tax_information', 'louisiana_income_tax_information');
        $app['config']->set('taxes.tables.us.maryland.maryland_income_tax_information', 'maryland_income_tax_information');
        $app['config']->set('taxes.tables.us.massachusetts.massachusetts_income_tax_information', 'massachusetts_income_tax_information');
        $app['config']->set('taxes.tables.us.michigan.michigan_income_tax_information', 'michigan_income_tax_information');
        $app['config']->set('taxes.tables.us.mississippi.mississippi_income_tax_information', 'mississippi_income_tax_information');
        $app['config']->set('taxes.tables.us.new_jersey.new_jersey_income_tax_information', 'new_jersey_income_tax_information');
        $app['config']->set('taxes.tables.us.new_york.new_york_income_tax_information', 'new_york_income_tax_information');
        $app['config']->set('taxes.tables.us.ohio.ohio_income_tax_information', 'ohio_income_tax_information');
        $app['config']->set('taxes.tables.us.oklahoma.oklahoma_income_tax_information', 'oklahoma_income_tax_information');
        $app['config']->set('taxes.tables.us.pennsylvania.pennsylvania_income_tax_information', 'pennsylvania_income_tax_information');
        $app['config']->set('taxes.tables.us.vermont.vermont_income_tax_information', 'vermont_income_tax_information');
        $app['config']->set('taxes.tables.us.virginia.virginia_income_tax_information', 'virginia_income_tax_information');
        $app['config']->set('taxes.tables.us.washington.washington_workers_compensation_tax_information', 'washington_workers_compensation_tax_information');
        $app['config']->set('taxes.tables.us.washingtondc.washingtondc_income_tax_information', 'washingtondc_income_tax_information');
        $app['config']->set('taxes.tables.us.wisconsin.wisconsin_income_tax_information', 'wisconsin_income_tax_information');
    }

    protected function getPackageProviders($app)
    {
        return [
            TaxesServiceProvider::class,
        ];
    }
}
