<?php

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\Alabama\AlabamaIncome\AlabamaIncome;
use Appleton\Taxes\Countries\US\Colorado\ColoradoIncome\ColoradoIncome;
use Appleton\Taxes\Countries\US\Georgia\GeorgiaIncome\GeorgiaIncome;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Countries\US\NewMexico\NewMexicoIncome\NewMexicoIncome;
use Appleton\Taxes\Countries\US\NorthCarolina\NorthCarolinaIncome\NorthCarolinaIncome;
use Appleton\Taxes\Countries\US\Wisconsin\WisconsinIncome\WisconsinIncome;
use Appleton\Taxes\Models\Countries\US\Alabama\AlabamaIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\Arizona\ArizonaIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\Colorado\ColoradoIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\Georgia\GeorgiaIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\NewMexico\NewMexicoIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\NorthCarolina\NorthCarolinaIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\Wisconsin\WisconsinIncomeTaxInformation;
use Appleton\Taxes\Providers\TaxesServiceProvider;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Orchestra\Database\ConsoleServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;

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

        ArizonaIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'percentage_withheld' => 0,
        ], $this->user);

        ColoradoIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'exemptions' => 0,
            'filing_status' => ColoradoIncome::FILING_SINGLE,
        ], $this->user);

        GeorgiaIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'allowances' => 0,
            'dependents' => 0,
            'personal_allowances' => 0,
            'filing_status' => GeorgiaIncome::FILING_SINGLE,
        ], $this->user);

        NewMexicoIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'exemptions' => 0,
            'filing_status' => NewMexicoIncome::FILING_SINGLE,
        ], $this->user);

        NorthCarolinaIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'dependents' => 0,
            'filing_status' => NorthCarolinaIncome::FILING_SINGLE,
        ], $this->user);

        WisconsinIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'exemptions' => 0,
            'filing_status' => WisconsinIncome::FILING_SINGLE,
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
            'us.alabama.beaverton' => [33.9312, -88.0203],
            'us.alabama.bessemer' => [33.4018, -86.9544],
            'us.alabama.birmingham' => [33.5207, -86.8025],
            'us.alabama.brilliant' => [34.0254, -87.7584],
            'us.alabama.fairfield' => [33.4859, -86.9119],
            'us.alabama.fortdeposit' => [31.9846, -86.5786],
            'us.alabama.gadsden' => [34.0143, -86.0066],
            'us.alabama.glencoe' => [33.9570, -85.9320],
            'us.alabama.goodwater' => [33.0657, -86.0533],
            'us.alabama.guin' => [33.9657, -87.9147],
            'us.alabama.hackleburg' => [34.2773, -87.8286],
            'us.alabama.haleyville' => [34.2265, -87.6214],
            'us.alabama.hamilton' => [34.1423, -87.9886],
            'us.alabama.hobsoncity' => [33.6215, -85.8441],
            'us.alabama.irondale' => [33.5382, -86.7072],
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
            'us.alabama.tarrant' => [33.5868, -86.7718],
            'us.alabama.tuskegee' => [32.4302, -85.7077],
            'us.arizona' => [33.6050991, -112.4052392],
            'us.colorado' => [39.7640021, -105.1352965],
            'us.georgia' => [33.7490, -84.3880],
            'us.florida' => [27.6648, -81.5158],
            'us.new_mexico' => [34.5199, -105.8701],
            'us.north_carolina' => [35.7596, -79.0193],
            'us.tennessee' => [35.5175, -86.5804],
            'us.texas' => [31.9686, -99.9018],
            'us.wisconsin' => [43.0849721, -89.4764603],
        ];

        return $locations[$name];
    }

    protected function getEnvironmentSetUp($app)
    {

        $app->useEnvironmentPath(__DIR__.'/..');
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

        $app['config']->set('taxes.user', Illuminate\Foundation\Auth\User::class);

        $app['config']->set('taxes.tables.governmental_unit_areas', 'governmental_unit_areas');
        $app['config']->set('taxes.tables.tax_areas', 'tax_areas');
        $app['config']->set('taxes.tables.tax_information', 'tax_information');
        $app['config']->set('taxes.tables.us.federal_income_tax_information', 'federal_income_tax_information');
        $app['config']->set('taxes.tables.us.alabama.alabama_income_tax_information', 'alabama_income_tax_information');
        $app['config']->set('taxes.tables.us.arizona.arizona_income_tax_information', 'arizona_income_tax_information');
        $app['config']->set('taxes.tables.us.colorado.colorado_income_tax_information', 'colorado_income_tax_information');
        $app['config']->set('taxes.tables.us.georgia.georgia_income_tax_information', 'georgia_income_tax_information');
        $app['config']->set('taxes.tables.us.wisconsin.wisconsin_income_tax_information', 'wisconsin_income_tax_information');
    }

    protected function getPackageProviders($app)
    {
        return [
            ConsoleServiceProvider::class,
            TaxesServiceProvider::class,
        ];
    }

    protected function emptyWorker()
    {
        return $this->user_model->forceCreate([
            'name' => 'Worker Dude',
            'email' => 'worker_dudeA@user.email',
            'password' => 'password',
        ]);
    }

    protected function createWorkerA()
    {
        // Worker A
        // YTD              $7,340.50
        // Filing Status    Single
        // Allowances       0
        // ADD Withholding  0
        // Gross Wages      $270.00

        $worker = $this->user_model->forceCreate([
            'name' => 'Worker A',
            'email' => 'workerA@user.email',
            'password' => 'password',
        ]);

        FederalIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'exemptions' => 0,
            'filing_status' => FederalIncome::FILING_SINGLE,
            'non_resident_alien' => false,
        ], $worker);

        AlabamaIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'dependents' => 0,
            'filing_status' => AlabamaIncome::FILING_SINGLE,
        ], $worker);

        ArizonaIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'percentage_withheld' => 0,
        ], $worker);

        ColoradoIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'exemptions' => 0,
            'filing_status' => ColoradoIncome::FILING_SINGLE,
        ], $worker);

        GeorgiaIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'allowances' => 0,
            'dependents' => 0,
            'personal_allowances' => 0,
            'filing_status' => GeorgiaIncome::FILING_SINGLE,
        ], $worker);

        NewMexicoIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'exemptions' => 0,
            'filing_status' => NewMexicoIncome::FILING_SINGLE,
        ], $worker);

        NorthCarolinaIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'dependents' => 0,
            'filing_status' => NorthCarolinaIncome::FILING_SINGLE,
        ], $worker);

        WisconsinIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'exemptions' => 0,
            'filing_status' => WisconsinIncome::FILING_SINGLE,
        ], $worker);

        return $worker;
    }


    protected function createWorkerB()
    {
        // Worker B
        // YTD              $17,845.00
        // Filing Status    Single
        // Allowances       3
        // ADD Withholding  0
        // Gross Wages      $785.00

        $worker = $this->user_model->forceCreate([
            'name' => 'Worker B',
            'email' => 'workerB@user.email',
            'password' => 'password',
        ]);

        FederalIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'exemptions' => 3,
            'filing_status' => FederalIncome::FILING_SINGLE,
            'non_resident_alien' => false,
        ], $worker);

        AlabamaIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'dependents' => 0,
            'filing_status' => AlabamaIncome::FILING_SINGLE,
        ], $worker);

        ArizonaIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'percentage_withheld' => 0,
        ], $worker);

        ColoradoIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'exemptions' => 3,
            'filing_status' => ColoradoIncome::FILING_SINGLE,
        ], $worker);

        GeorgiaIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'allowances' => 3,
            'dependents' => 0,
            'personal_allowances' => 0,
            'filing_status' => GeorgiaIncome::FILING_SINGLE,
        ], $worker);

        NewMexicoIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'exemptions' => 3,
            'filing_status' => NewMexicoIncome::FILING_SINGLE,
        ], $worker);

        NorthCarolinaIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'dependents' => 0,
            'filing_status' => NorthCarolinaIncome::FILING_SINGLE,
        ], $worker);

        WisconsinIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'exemptions' => 3,
            'filing_status' => WisconsinIncome::FILING_SINGLE,
        ], $worker);

        return $worker;
    }

    protected function createWorkerC()
    {
        // Worker C
        // YTD              $255.00
        // Filing Status    Married
        // Allowances       0
        // ADD Withholding  0
        // Gross Wages      $160.80

        $worker = $this->user_model->forceCreate([
            'name' => 'Worker C',
            'email' => 'workerC@user.email',
            'password' => 'password',
        ]);

        FederalIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'exemptions' => 0,
            'filing_status' => FederalIncome::FILING_MARRIED,
            'non_resident_alien' => false,
        ], $worker);

        AlabamaIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'dependents' => 0,
            'filing_status' => AlabamaIncome::FILING_MARRIED,
        ], $worker);

        ArizonaIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'percentage_withheld' => 0,
        ], $worker);

        ColoradoIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'exemptions' => 0,
            'filing_status' => ColoradoIncome::FILING_MARRIED,
        ], $worker);

        GeorgiaIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'allowances' => 0,
            'dependents' => 0,
            'personal_allowances' => 0,
            'filing_status' => GeorgiaIncome::FILING_MARRIED_JOINT_BOTH_WORKING,
        ], $worker);

        NewMexicoIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'exemptions' => 0,
            'filing_status' => NewMexicoIncome::FILING_MARRIED,
        ], $worker);

        NorthCarolinaIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'dependents' => 0,
            'filing_status' => NorthCarolinaIncome::FILING_MARRIED,
        ], $worker);

        WisconsinIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'exemptions' => 0,
            'filing_status' => WisconsinIncome::FILING_MARRIED,
        ], $worker);

        return $worker;
    }


    protected function createWorkerD()
    {
        // Worker D
        // YTD              $0.00
        // Filing Status    Married
        // Allowances       5
        // ADD Withholding  $15
        // Gross Wages      $280.00

        $worker = $this->user_model->forceCreate([
            'name' => 'Worker D',
            'email' => 'workerD@user.email',
            'password' => 'password',
        ]);

        FederalIncomeTaxInformation::createForUser([
            'additional_withholding' => 15,
            'exemptions' => 5,
            'filing_status' => FederalIncome::FILING_MARRIED,
            'non_resident_alien' => false,
        ], $worker);

        AlabamaIncomeTaxInformation::createForUser([
            'additional_withholding' => 15,
            'dependents' => 0,
            'filing_status' => AlabamaIncome::FILING_MARRIED,
        ], $worker);

        ArizonaIncomeTaxInformation::createForUser([
            'additional_withholding' => 15,
            'percentage_withheld' => 0,
        ], $worker);

        ColoradoIncomeTaxInformation::createForUser([
            'additional_withholding' => 15,
            'exemptions' => 5,
            'filing_status' => ColoradoIncome::FILING_MARRIED,
        ], $worker);

        GeorgiaIncomeTaxInformation::createForUser([
            'additional_withholding' => 15,
            'allowances' => 5,
            'dependents' => 0,
            'personal_allowances' => 0,
            'filing_status' => GeorgiaIncome::FILING_MARRIED_JOINT_BOTH_WORKING,
        ], $worker);

        NewMexicoIncomeTaxInformation::createForUser([
            'additional_withholding' => 15,
            'exemptions' => 5,
            'filing_status' => NewMexicoIncome::FILING_MARRIED,
        ], $worker);

        NorthCarolinaIncomeTaxInformation::createForUser([
            'additional_withholding' => 15,
            'dependents' => 0,
            'filing_status' => NorthCarolinaIncome::FILING_MARRIED,
        ], $worker);

        WisconsinIncomeTaxInformation::createForUser([
            'additional_withholding' => 15,
            'exemptions' => 5,
            'filing_status' => WisconsinIncome::FILING_MARRIED,
        ], $worker);

        return $worker;
    }


    protected function createWorkerE()
    {
        // Worker E
        // YTD              $5,432.12
        // Filing Status    Single
        // Allowances       1
        // ADD Withholding  $25
        // Gross Wages      $455.00

        $worker = $this->user_model->forceCreate([
            'name' => 'Worker E',
            'email' => 'workerE@user.email',
            'password' => 'password',
        ]);

        FederalIncomeTaxInformation::createForUser([
            'additional_withholding' => 25,
            'exemptions' => 1,
            'filing_status' => FederalIncome::FILING_SINGLE,
            'non_resident_alien' => false,
        ], $worker);

        AlabamaIncomeTaxInformation::createForUser([
            'additional_withholding' => 25,
            'dependents' => 0,
            'filing_status' => AlabamaIncome::FILING_SINGLE,
        ], $worker);

        ArizonaIncomeTaxInformation::createForUser([
            'additional_withholding' => 25,
            'percentage_withheld' => 0,
        ], $worker);

        ColoradoIncomeTaxInformation::createForUser([
            'additional_withholding' => 25,
            'exemptions' => 1,
            'filing_status' => ColoradoIncome::FILING_SINGLE,
        ], $worker);

        GeorgiaIncomeTaxInformation::createForUser([
            'additional_withholding' => 25,
            'allowances' => 1,
            'dependents' => 0,
            'personal_allowances' => 0,
            'filing_status' => GeorgiaIncome::FILING_SINGLE,
        ], $worker);

        NewMexicoIncomeTaxInformation::createForUser([
            'additional_withholding' => 25,
            'exemptions' => 1,
            'filing_status' => NewMexicoIncome::FILING_SINGLE,
        ], $worker);

        NorthCarolinaIncomeTaxInformation::createForUser([
            'additional_withholding' => 25,
            'dependents' => 0,
            'filing_status' => NorthCarolinaIncome::FILING_SINGLE,
        ], $worker);

        WisconsinIncomeTaxInformation::createForUser([
            'additional_withholding' => 25,
            'exemptions' => 1,
            'filing_status' => WisconsinIncome::FILING_SINGLE,
        ], $worker);

        return $worker;
    }

    protected function createWorkerF()
    {
        // Worker F
        // YTD              $10,432.12
        // Filing Status    Married
        // Allowances       0
        // ADD Withholding  $0
        // Gross Wages      $365.00

        $worker = $this->user_model->forceCreate([
            'name' => 'Worker F',
            'email' => 'workerF@user.email',
            'password' => 'password',
        ]);

        FederalIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'exemptions' => 0,
            'filing_status' => FederalIncome::FILING_MARRIED,
            'non_resident_alien' => false,
        ], $worker);

        AlabamaIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'dependents' => 0,
            'filing_status' => AlabamaIncome::FILING_MARRIED,
        ], $worker);

        ArizonaIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'percentage_withheld' => 0,
        ], $worker);

        ColoradoIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'exemptions' => 0,
            'filing_status' => ColoradoIncome::FILING_MARRIED,
        ], $worker);

        GeorgiaIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'allowances' => 0,
            'dependents' => 0,
            'personal_allowances' => 0,
            'filing_status' => GeorgiaIncome::FILING_MARRIED_JOINT_BOTH_WORKING,
        ], $worker);

        NewMexicoIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'exemptions' => 0,
            'filing_status' => NewMexicoIncome::FILING_MARRIED,
        ], $worker);

        NorthCarolinaIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'dependents' => 0,
            'filing_status' => NorthCarolinaIncome::FILING_SINGLE,
        ], $worker);

        WisconsinIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'exemptions' => 0,
            'filing_status' => WisconsinIncome::FILING_SINGLE,
        ], $worker);

        return $worker;
    }

    protected function createWorkerG()
    {
        // Worker E
        // YTD              $20,000.00
        // Filing Status    Single
        // Allowances       8
        // ADD Withholding  $0
        // Gross Wages      $625.00

        $worker = $this->user_model->forceCreate([
            'name' => 'Worker E',
            'email' => 'workerE@user.email',
            'password' => 'password',
        ]);

        FederalIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'exemptions' => 8,
            'filing_status' => FederalIncome::FILING_SINGLE,
            'non_resident_alien' => false,
        ], $worker);

        AlabamaIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'dependents' => 0,
            'filing_status' => AlabamaIncome::FILING_SINGLE,
        ], $worker);

        ArizonaIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'percentage_withheld' => 0,
        ], $worker);

        ColoradoIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'exemptions' => 8,
            'filing_status' => ColoradoIncome::FILING_SINGLE,
        ], $worker);

        GeorgiaIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'allowances' => 8,
            'dependents' => 0,
            'personal_allowances' => 0,
            'filing_status' => GeorgiaIncome::FILING_SINGLE,
        ], $worker);

        NewMexicoIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'exemptions' => 8,
            'filing_status' => NewMexicoIncome::FILING_SINGLE,
        ], $worker);

        NorthCarolinaIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'dependents' => 0,
            'filing_status' => NorthCarolinaIncome::FILING_SINGLE,
        ], $worker);

        WisconsinIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'exemptions' => 8,
            'filing_status' => WisconsinIncome::FILING_SINGLE,
        ], $worker);

        return $worker;
    }
}
