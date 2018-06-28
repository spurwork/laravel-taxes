<?php

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\Alabama\AlabamaIncome\AlabamaIncome;
use Appleton\Taxes\Countries\US\Georgia\GeorgiaIncome\GeorgiaIncome;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Countries\US\NorthCarolina\NorthCarolinaIncome\NorthCarolinaIncome;
use Appleton\Taxes\Models\Countries\US\Alabama\AlabamaIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\Georgia\GeorgiaIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\NorthCarolina\NorthCarolinaIncomeTaxInformation;
use Appleton\Taxes\Providers\TaxesServiceProvider;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Orchestra\Database\ConsoleServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    use DatabaseTransactions;

    public function date($date)
    {
        return Carbon::parse($date);
    }

    public function setUp()
    {
        parent::setUp();

        Carbon::setTestNow(
            Carbon::parse('January 1, 2017 8am', 'America/Chicago')->setTimezone('UTC')
        );

        $this->loadLaravelMigrations(['--database' => 'testing']);

        $this->loadMigrationsFrom([
            '--database' => 'testing',
            '--realpath' => realpath(__DIR__.'/../src/migrations'),
        ]);

        $this->user_model = app(config('taxes.user'));

        $this->user = $this->user_model->forceCreate([
            'name' => 'Test User',
            'email' => 'test@user.email',
            'password' => 'password',
        ]);

        $this->taxes = $this->app->make(Taxes::class);

        FederalIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'exemptions' => 0,
            'filing_status' => FederalIncome::FILING_SINGLE,
            'non_resident_alien' => false,
        ], $this->user);

        AlabamaIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'dependents' => 0,
            'filing_status' => AlabamaIncome::FILING_SINGLE,
        ], $this->user);

        GeorgiaIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'allowances' => 0,
            'dependents' => 0,
            'personal_allowances' => 0,
            'filing_status' => GeorgiaIncome::FILING_SINGLE,
        ], $this->user);

        NorthCarolinaIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'dependents' => 0,
            'filing_status' => NorthCarolinaIncome::FILING_SINGLE,
        ], $this->user);
    }

    protected function getLocation($name)
    {
        $locations = [
            'us' => [38.9072, -77.0369],
            'us.alabama' => [32.3182, -86.9023],
            'us.alabama.attalla' => [34.0218, -86.0886],
            'us.alabama.auburn' => [32.6099, -85.4808],
            'us.alabama.bearcreek' => [34.2748, -87.7006],
            'us.alabama.bessemer' => [33.4018, -86.9544],
            'us.alabama.birmingham' => [33.5207, -86.8025],
            'us.alabama.brilliant' => [34.0254, -87.7584],
            'us.alabama.fairfield' => [33.4859, -86.9119],
            'us.alabama.gadsden' => [34.0143, -86.0066],
            'us.alabama.glencoe' => [33.9570, -85.9320],
            'us.alabama.goodwater' => [33.0657, -86.0533],
            'us.alabama.guin' => [33.9657, -87.9147],
            'us.alabama.hackleburg' => [34.2773, -87.8286],
            'us.alabama.haleyville' => [34.2265, -87.6214],
            'us.alabama.hamilton' => [34.1423, -87.9886],
            'us.alabama.leeds' => [33.5482, -86.5444],
            'us.alabama.lynn' => [34.0470, -87.5497],
            'us.alabama.maconcounty' => [32.3731, -85.6846],
            'us.alabama.midfield' => [33.4615, -86.9089],
            'us.alabama.mosses' => [32.1793, -86.6737],
            'us.alabama.opelika' => [32.6454, -85.3783],
            'us.alabama.rainbowcity' => [33.9548, -86.0419],
            'us.alabama.redbay' => [34.4398, -88.1409],
            'us.alabama.shorter' => [32.3951, -85.9184],
            'us.alabama.southside' => [33.9245, -86.0225],
            'us.alabama.sulligent' => [33.9018, -88.1345],
            'us.alabama.tuskegee' => [32.4302, -85.7077],
            'us.georgia' => [33.7490, -84.3880],
            'us.north_carolina' => [35.7596, -79.0193],
            'us.tennessee' => [35.5175, -86.5804],
        ];

        return $locations[$name];
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
        $app['config']->set('taxes.tables.us.georgia.georgia_income_tax_information', 'georgia_income_tax_information');
    }

    protected function getPackageProviders($app)
    {
        return [
            ConsoleServiceProvider::class,
            TaxesServiceProvider::class,
        ];
    }
}
