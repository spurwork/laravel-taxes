<?php

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\Alabama\AlabamaIncome\AlabamaIncome;
use Appleton\Taxes\Countries\US\Colorado\ColoradoIncome\ColoradoIncome;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Countries\US\Georgia\GeorgiaIncome\GeorgiaIncome;
use Appleton\Taxes\Countries\US\Louisiana\LouisianaIncome\LouisianaIncome;
use Appleton\Taxes\Countries\US\Maryland\MarylandIncome\MarylandIncome;
use Appleton\Taxes\Countries\US\Massachusetts\MassachusettsIncome\MassachusettsIncome;
use Appleton\Taxes\Countries\US\Michigan\MichiganIncome\MichiganIncome;
use Appleton\Taxes\Countries\US\Mississippi\MississippiIncome\MississippiIncome;
use Appleton\Taxes\Countries\US\NewJersey\NewJerseyIncome\NewJerseyIncome;
use Appleton\Taxes\Countries\US\NewMexico\NewMexicoIncome\NewMexicoIncome;
use Appleton\Taxes\Countries\US\NewYork\NewYorkIncome\NewYorkIncome;
use Appleton\Taxes\Countries\US\NorthCarolina\NorthCarolinaIncome\NorthCarolinaIncome;
use Appleton\Taxes\Countries\US\Oklahoma\OklahomaIncome\OklahomaIncome;
use Appleton\Taxes\Countries\US\WashingtonDC\WashingtonDCIncome\WashingtonDCIncome;
use Appleton\Taxes\Countries\US\Wisconsin\WisconsinIncome\WisconsinIncome;
use Appleton\Taxes\Models\Countries\US\Alabama\AlabamaIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\Arizona\ArizonaIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\Colorado\ColoradoIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\Georgia\GeorgiaIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\Illinois\IllinoisIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\Indiana\IndianaIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\Kentucky\KentuckyIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\Louisiana\LouisianaIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\Maryland\MarylandIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\Massachusetts\MassachusettsIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\Michigan\MichiganIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\Mississippi\MississippiIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\NewJersey\NewJerseyIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\NewMexico\NewMexicoIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\NewYork\NewYorkIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\NorthCarolina\NorthCarolinaIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\Oklahoma\OklahomaIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\Virginia\VirginiaIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\WashingtonDC\WashingtonDCIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\Wisconsin\WisconsinIncomeTaxInformation;
use Appleton\Taxes\Providers\TaxesServiceProvider;
use Carbon\Carbon;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Orchestra\Database\ConsoleServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

/**
 * @property Taxes $taxes
 */
class TestCase extends BaseTestCase
{
    use DatabaseMigrations;

    protected $user_model;
    protected $user;
    protected $taxes;

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

        IllinoisIncomeTaxInformation::createForUser([
            'basic_allowances' => 0,
            'additional_allowances' => 0,
            'additional_withholding' => 0,
            'exempt' => false,
        ], $this->user);

        IndianaIncomeTaxInformation::createForUser([
            'personal_exemptions' => 0,
            'dependent_exemptions' => 0,
            'additional_withholding' => 0,
            'additional_county_withholding' => 0,
            'county_lived' => 11,
            'county_worked' => 11,
        ], $this->user);

        KentuckyIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'exemptions' => 0,
        ], $this->user);

        LouisianaIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'dependents' => 0,
            'exemptions' => 0,
            'filing_status' => LouisianaIncome::FILING_SINGLE,
        ], $this->user);

        MarylandIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'dependents' => 0,
            'filing_status' => MarylandIncome::FILING_SINGLE,
        ], $this->user);

        MassachusettsIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'exemptions' => 0,
            'blind' => 0,
            'filing_status' => MassachusettsIncome::FILING_SINGLE,
            'exempt' => false,
        ], $this->user);

        MichiganIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'dependents' => 0,
            'filing_status' => MichiganIncome::FILING_SINGLE,
            'exempt' => false,
        ], $this->user);

        MississippiIncomeTaxInformation::createForUser([
            'total_exemption_amount_dollars' => 0,
            'additional_withholding' => 0,
            'filing_status' => MississippiIncome::FILING_SINGLE,
            'exempt' => false,
        ], $this->user);

        NewJerseyIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'exemptions' => 0,
            'filing_status' => NewJerseyIncome::FILING_SINGLE,
            'tax_rate_table' => null,
        ], $this->user);

        NewMexicoIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'exemptions' => 0,
            'filing_status' => NewMexicoIncome::FILING_SINGLE,
        ], $this->user);

        NewYorkIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'exemptions' => 0,
            'filing_status' => NewYorkIncome::FILING_SINGLE,
        ], $this->user);

        NorthCarolinaIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'dependents' => 0,
            'filing_status' => NorthCarolinaIncome::FILING_SINGLE,
        ], $this->user);

        OklahomaIncomeTaxInformation::createForUser([
            'dependents' => 0,
            'exempt' => false,
            'filing_status' => OklahomaIncome::FILING_SINGLE,
        ], $this->user);

        VirginiaIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'exemptions' => 0,
            'sixty_five_plus_or_blind_exemptions' => 0,
        ], $this->user);

        WashingtonDCIncomeTaxInformation::createForUser([
            'dependents' => 0,
            'exempt' => false,
            'filing_status' => WashingtonDCIncome::FILING_SINGLE,
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
            'us' => [37.0902, -95.7129],
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
            'us.delaware' => [39.1582, -75.5244],
            'us.georgia' => [33.7490, -84.3880],
            'us.florida' => [27.6648, -81.5158],
            'us.illinois' => [39.7817, -89.6501],
            'us.indiana' => [39.7684, -86.1581],
            'us.indiana.adams' => [40.7249, -84.8985],
            'us.indiana.allen' => [41.0933, -85.0233],
            'us.indiana.bartholomew' => [39.2068, -85.8896],
            'us.indiana.benton' => [40.6448, -87.3414],
            'us.indiana.blackford' => [40.4993, -85.3136],
            'us.indiana.boone' => [40.0106, -86.4997],
            'us.indiana.brown' => [39.1750, -86.1752],
            'us.indiana.carroll' => [40.5424, -86.5401],
            'us.indiana.cass' => [40.8199, -86.3377],
            'us.indiana.clark' => [38.4493, -85.7256],
            'us.indiana.clay' => [39.3686, -87.1423],
            'us.indiana.clinton' => [40.3377, -86.4997],
            'us.indiana.crawford' => [38.3055, -86.4592],
            'us.indiana.daviess' => [38.7020, -87.1423],
            'us.indiana.dearborn' => [39.1713, -84.9818],
            'us.indiana.decatur' => [39.3176, -85.5200],
            'us.indiana.dekalb' => [41.4139, -85.0233],
            'us.indiana.delaware' => [40.2584, -85.3963],
            'us.indiana.dubois' => [38.3579, -86.8220],
            'us.indiana.elkhart' => [41.6062, -85.8486],
            'us.indiana.fayette' => [39.5920, -85.1479],
            'us.indiana.floyd' => [38.2869, -85.8896],
            'us.indiana.fountain' => [40.2227, -87.3348],
            'us.indiana.franklin' => [39.4234, -85.0649],
            'us.indiana.fulton' => [41.0204, -86.2971],
            'us.indiana.gibson' => [38.3338, -87.5791],
            'us.indiana.grant' => [40.4731, -85.6846],
            'us.indiana.greene' => [39.0322, -86.9824],
            'us.indiana.hamilton' => [40.0373, -86.0530],
            'us.indiana.hancock' => [39.8250, -85.8486],
            'us.indiana.harrison' => [38.1701, -86.1752],
            'us.indiana.hendricks' => [39.8065, -86.5401],
            'us.indiana.henry' => [39.9705, -85.3550],
            'us.indiana.howard' => [40.4483, -86.1345],
            'us.indiana.huntington' => [40.7911, -85.5200],
            'us.indiana.jackson' => [38.8794, -86.0530],
            'us.indiana.jasper' => [41.0041, -87.1423],
            'us.indiana.jay' => [40.4465, -85.0233],
            'us.indiana.jefferson' => [38.7752, -85.4788],
            'us.indiana.jennings' => [38.9915, -85.6846],
            'us.indiana.johnson' => [39.4638, -86.1345],
            'us.indiana.knox' => [38.6666, -87.4208],
            'us.indiana.kosciusko' => [41.2865, -85.8486],
            'us.indiana.lagrange' => [41.6289, -85.3963],
            'us.indiana.lake' => [41.4897, -87.3016],
            'us.indiana.laporte' => [41.4775, -86.8220],
            'us.indiana.lawrence' => [38.8519, -86.4997],
            'us.indiana.madison' => [40.1469, -85.6846],
            'us.indiana.marion' => [39.8362, -86.1752],
            'us.indiana.marshall' => [41.3030, -86.3377],
            'us.indiana.martin' => [38.6938, -86.8220],
            'us.indiana.miami' => [40.7701, -86.0530],
            'us.indiana.monroe' => [39.1851, -86.4997],
            'us.indiana.montgomery' => [40.0199, -86.8220],
            'us.indiana.morgan' => [39.5117, -86.3377],
            'us.indiana.newton' => [40.9703, -87.4208],
            'us.indiana.noble' => [41.4277, -85.3550],
            'us.indiana.ohio' => [38.9417, -84.9609],
            'us.indiana.orange' => [38.5169, -86.4997],
            'us.indiana.owen' => [39.3603, -86.8220],
            'us.indiana.parke' => [39.6993, -87.1423],
            'us.indiana.perry' => [38.0159, -86.6611],
            'us.indiana.pike' => [38.4111, -87.2618],
            'us.indiana.porter' => [41.5249, -87.1024],
            'us.indiana.posey' => [38.0020, -87.8942],
            'us.indiana.pulaski' => [40.9957, -86.8220],
            'us.indiana.putnam' => [39.6910, -86.8220],
            'us.indiana.randolph' => [40.1205, -85.0233],
            'us.indiana.ripley' => [39.0987, -85.2308],
            'us.indiana.rush' => [39.6482, -85.5200],
            'us.indiana.scott' => [38.7008, -85.7256],
            'us.indiana.shelby' => [39.4953, -85.8486],
            'us.indiana.spencer' => [37.9833, -87.0224],
            'us.indiana.stjoseph' => [41.6228, -86.3377],
            'us.indiana.starke' => [41.2716, -86.6208],
            'us.indiana.steuben' => [41.6115, -84.9818],
            'us.indiana.sullivan' => [39.0843, -87.4208],
            'us.indiana.switzerland' => [38.8419, -85.0649],
            'us.indiana.tippecanoe' => [40.3470, -86.8220],
            'us.indiana.tipton' => [40.2826, -86.0530],
            'us.indiana.union' => [39.6638, -84.8985],
            'us.indiana.vanderburgh' => [38.0806, -87.5791],
            'us.indiana.vermillion' => [39.8512, -87.4802],
            'us.indiana.vigo' => [39.4165, -87.4208],
            'us.indiana.wabash' => [40.8034, -85.8486],
            'us.indiana.warren' => [40.3192, -87.3414],
            'us.indiana.warrick' => [38.0737, -87.2618],
            'us.indiana.washington' => [38.6745, -86.1752],
            'us.indiana.wayne' => [39.8319, -84.9818],
            'us.indiana.wells' => [40.7778, -85.1894],
            'us.indiana.white' => [40.6766, -86.9824],
            'us.indiana.whitley' => [41.1136, -85.5200],
            'us.kentucky' => [37.8393, -84.2700],
            'us.kentucky.boone_county' => [38.9941, -84.7316],
            'us.kentucky.florence_city' => [38.9989, -84.6266],
            'us.kentucky.georgetown_city' => [38.2098, -84.5588],
            'us.kentucky.jefferson_county' => [38.1938, -85.6435],
            'us.kentucky.scott_county' => [38.3172, -84.5641],
            'us.massachusetts' => [42.4072, -71.3824],
            'us.louisiana' => [30.9843, -91.9623],
            'us.maryland' => [38.9784, -76.4922],
            'us.maryland.allegany' => [39.6255, -78.6115],
            'us.maryland.annearundel' => [38.9530, -76.5488],
            'us.maryland.baltimore' => [39.4648, -76.7337],
            'us.maryland.baltimorecity' => [39.2904, -76.6122],
            'us.maryland.calvert' => [38.4950, -76.5026],
            'us.maryland.caroline' => [38.9105, -75.8534],
            'us.maryland.carroll' => [39.5423, -77.0564],
            'us.maryland.cecil' => [39.5739, -75.9463],
            'us.maryland.charles' => [38.5222, -77.1025],
            'us.maryland.dorchester' => [38.4153, -76.1784],
            'us.maryland.frederick' => [39.384, -77.4702],
            'us.maryland.garrett' => [39.5681, -79.2902],
            'us.maryland.harford' => [39.5839, -76.363],
            'us.maryland.howard' => [39.2873, -76.9643],
            'us.maryland.kent' => [39.2189, -76.06904],
            'us.maryland.montgomery' => [39.1547, -77.2405],
            'us.maryland.princegeorges' => [38.7849, -76.8721],
            'us.maryland.queenannes' => [39.0264, -76.1320],
            'us.maryland.stmarys' => [38.1060, -76.3637],
            'us.maryland.somerset' => [38.0862, -75.8534],
            'us.maryland.talbot' => [38.7804, -76.1320],
            'us.maryland.washington' => [39.6418, -77.7200],
            'us.maryland.wicomico' => [38.3942, -75.6674],
            'us.maryland.worcester' => [38.1584, -75.4345],
            'us.michigan' => [42.7325, -84.5555],
            'us.mississippi' => [32.3547, -89.3985],
            'us.new_jersey' => [40.2206, -74.7597],
            'us.new_jersey.newark' => [40.7357, -74.1724],
            'us.new_mexico' => [34.5199, -105.8701],
            'us.new_york' => [40.7128, -74.0060],
            'us.new_york.yonkers' => [40.9312, -73.8987],
            'us.north_carolina' => [35.7596, -79.0193],
            'us.oklahoma' => [35.4676, -97.5164],
            'us.tennessee' => [35.5175, -86.5804],
            'us.texas' => [31.9686, -99.9018],
            'us.virginia' => [37.5407, -77.4360],
            'us.washingtondc' => [38.9072, -77.0369],
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
        $app['config']->set('taxes.tables.us.oklahoma.oklahoma_income_tax_information', 'oklahoma_income_tax_information');
        $app['config']->set('taxes.tables.us.virginia.virginia_income_tax_information', 'virginia_income_tax_information');
        $app['config']->set('taxes.tables.us.washingtondc.washingtondc_income_tax_information', 'washingtondc_income_tax_information');
        $app['config']->set('taxes.tables.us.wisconsin.wisconsin_income_tax_information', 'wisconsin_income_tax_information');
    }

    protected function getPackageProviders($app)
    {
        return [
            ConsoleServiceProvider::class,
            TaxesServiceProvider::class,
        ];
    }
}
