<?php

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\Alabama\AlabamaIncome\AlabamaIncome;
use Appleton\Taxes\Countries\US\California\CaliforniaIncome\CaliforniaIncome;
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
use Appleton\Taxes\Models\Countries\US\California\CaliforniaIncomeTaxInformation;
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
use Appleton\Taxes\Models\Countries\US\Ohio\OhioIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\Oklahoma\OklahomaIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\Virginia\VirginiaIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\WashingtonDC\WashingtonDCIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\WestVirginia\WestVirginiaIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\Wisconsin\WisconsinIncomeTaxInformation;
use Appleton\Taxes\Providers\TaxesServiceProvider;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User;
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

        CaliforniaIncomeTaxInformation::createForUser([
            'filing_status' => CaliforniaIncome::FILING_SINGLE,
            'allowances' => 0,
            'estimated_deductions' => 0,
            'additional_withholding' => 0,
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

        OhioIncomeTaxInformation::createForUser([
            'dependents' => 0,
            'exempt' => false,
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

        WestVirginiaIncomeTaxInformation::createForUser([
            'two_earner_percent' => false,
            'allowances' => 0,
            'additional_withholding' => 0,
            'exempt' => false,
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
            'us.california' => [38.5816, -121.4944],
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
            'us.kentucky.adairville_city' => [36.6675425, -86.8519417],
            'us.kentucky.allen_county' => [36.7650471, -86.2158497],
            'us.kentucky.ashland_city' => [38.4784144, -82.6379387],
            'us.kentucky.auburn_city' => [36.8642088, -86.7102735],
            'us.kentucky.ballard_county' => [37.0359869, -89.0179332],
            'us.kentucky.bardstown_city' => [37.8092279, -85.4669025],
            'us.kentucky.bardwell_city' => [36.8706111, -89.0097869],
            'us.kentucky.bath_county' => [38.1068164, -83.7199136],
            'us.kentucky.beattyville_city' => [37.5717532, -83.7068597],
            'us.kentucky.bellevue_city' => [39.1064488, -84.478831],
            'us.kentucky.benton_city' => [36.8572781, -88.350315],
            'us.kentucky.berea_city' => [37.568694, -84.2963223],
            'us.kentucky.boone_county' => [38.9941, -84.7316],
            'us.kentucky.bourbon_county' => [38.2170752, -84.2278796],
            'us.kentucky.bowling_green_city' => [36.9685219, -86.4808043],
            'us.kentucky.boyd_county' => [38.3833265, -82.6915429],
            'us.kentucky.boyle_county' => [37.6526034, -84.8150781],
            'us.kentucky.breathitt_county' => [37.5359616, -83.336188],
            'us.kentucky.brodhead_city' => [37.4042496, -84.4138259],
            'us.kentucky.bromley_city' => [39.0820043, -84.5602215],
            'us.kentucky.brownsville_city' => [37.1925472, -86.2677545],
            'us.kentucky.butler_county' => [37.2086395, -86.7013894],
            'us.kentucky.cadiz_city' => [36.8650496, -87.835295],
            'us.kentucky.caldwell_county' => [37.1501019, -87.8942451],
            'us.kentucky.calvert_city' => [37.0333896, -88.3500362],
            'us.kentucky.camargo_city' => [37.9942469, -83.8876978],
            'us.kentucky.campbellsville_city' => [37.3433974, -85.3419069],
            'us.kentucky.carlisle_city' => [38.3120197, -84.027427],
            'us.kentucky.catlettsburg_city' => [38.4048042, -82.6004369],
            'us.kentucky.cave_city' => [37.1367171, -85.9569195],
            'us.kentucky.clark_county' => [37.959945, -84.1435136],
            'us.kentucky.clarkson_city' => [37.4953332, -86.2213614],
            'us.kentucky.clay_city' => [37.8592479, -83.9185323],
            'us.kentucky.clay_county' => [37.1738044, -83.7199136],
            'us.kentucky.clinton_county' => [36.7263899, -85.1479364],
            'us.kentucky.coal_run_village_city' => [37.5131553, -82.5584861],
            'us.kentucky.crescent_springs_city' => [39.0514492, -84.5816106],
            'us.kentucky.crittenden_county' => [37.3673645, -88.0900762],
            'us.kentucky.cynthiana_city' => [38.3903526, -84.2941013],
            'us.kentucky.danville_city' => [37.6456329, -84.7721702],
            'us.kentucky.daviess_county' => [37.7307984, -87.1023746],
            'us.kentucky.dawson_springs_city' => [37.1672684, -87.6925074],
            'us.kentucky.dayton_city' => [39.1128377, -84.4727197],
            'us.kentucky.dry_ridge_city' => [38.6820122, -84.5899426],
            'us.kentucky.earlington_city' => [37.2742117, -87.5119435],
            'us.kentucky.eddyville_city' => [37.0944971, -88.080301],
            'us.kentucky.edgewood_city' => [39.0186719, -84.581888],
            'us.kentucky.edmonton_city' => [36.9800563, -85.6121906],
            'us.kentucky.elizabethtown_city' => [37.7030646, -85.8649408],
            'us.kentucky.elkhorn_city' => [37.303997, -82.3509794],
            'us.kentucky.elkton_city' => [36.8100425, -87.1541675],
            'us.kentucky.elsmere_city' => [39.0125608, -84.6046663],
            'us.kentucky.eminence_city' => [38.3700683, -85.1805105],
            'us.kentucky.erlanger_city' => [39.0167275, -84.6007773],
            'us.kentucky.estill_county' => [37.6975384, -83.9744262],
            'us.kentucky.fayette_county' => [38.0406, -84.5037],
            'us.kentucky.flemingsburg_city' => [38.4222995, -83.7338076],
            'us.kentucky.florence_city' => [38.9989, -84.6266],
            'us.kentucky.fort_mitchell_city' => [39.0472046, -84.5599169],
            'us.kentucky.fort_thomas_city' => [39.0750607, -84.4471633],
            'us.kentucky.frankfort_city' => [38.2009055, -84.8732835],
            'us.kentucky.franklin_city' => [36.722263, -86.5772177],
            'us.kentucky.franklin_county' => [38.2481018, -84.8984775],
            'us.kentucky.fulton_city' => [36.5042277, -88.8742259],
            'us.kentucky.gallatin_county' => [38.7295069, -84.8776392],
            'us.kentucky.garrard_county' => [37.6413234, -84.564147],
            'us.kentucky.georgetown_city' => [38.2098, -84.5588],
            'us.kentucky.glasgow_city' => [36.9958839, -85.9119215],
            'us.kentucky.grant_county' => [38.6565245, -84.6479124],
            'us.kentucky.graves_county' => [36.6887728, -88.7108964],
            'us.kentucky.grayson_city' => [38.3325812, -82.9485023],
            'us.kentucky.grayson_county' => [37.4554962, -86.3782198],
            'us.kentucky.greensburg_city' => [37.2608936, -85.4988548],
            'us.kentucky.greenup_city' => [38.5731349, -82.8301677],
            'us.kentucky.guthrie_city' => [36.6483777, -87.1663917],
            'us.kentucky.hancock_county' => [37.8280909, -86.761749],
            'us.kentucky.harrison_county' => [38.4333045, -84.3542049],
            'us.kentucky.harrodsburg_city' => [37.762298, -84.8432852],
            'us.kentucky.hart_county' => [37.3101304, -85.8486236],
            'us.kentucky.hartford_city' => [37.4511591, -86.9091596],
            'us.kentucky.henderson_city' => [37.8361538, -87.5900134],
            'us.kentucky.henderson_county' => [37.7415161, -87.5791287],
            'us.kentucky.hickman_city' => [36.5711721, -89.1861791],
            'us.kentucky.hickman_county' => [36.6482184, -88.9796776],
            'us.kentucky.hillview_city' => [38.0764762, -85.6813239],
            'us.kentucky.hodgenville_city' => [37.5739497, -85.7399606],
            'us.kentucky.hopkins_county' => [37.3153093, -87.5791287],
            'us.kentucky.hopkinsville_city' => [36.8656008, -87.4886186],
            'us.kentucky.horse_cave_city' => [37.179496, -85.9069175],
            'us.kentucky.independence_city' => [38.9431183, -84.544109],
            'us.kentucky.jackson_city' => [37.5531457, -83.3835135],
            'us.kentucky.jackson_county' => [37.4023274, -84.0167423],
            'us.kentucky.jamestown_city' => [36.9847899, -85.06301],
            'us.kentucky.jefferson_county' => [38.1938, -85.6435],
            'us.kentucky.jeffersontown_city' => [38.1942356, -85.5644033],
            'us.kentucky.jeffersonville_city' => [37.9736917, -83.8418631],
            'us.kentucky.jessamine_county' => [37.895573, -84.564147],
            'us.kentucky.johnson_county' => [37.8048335, -82.8640623],
            'us.kentucky.junction_city' => [37.5867433, -84.7938377],
            'us.kentucky.knox_county' => [36.9260578, -83.8897057],
            'us.kentucky.la_grange_city' => [38.4075666, -85.3788468],
            'us.kentucky.lakeside_park_city' => [39.0356162, -84.5691102],
            'us.kentucky.lancaster_city' => [37.6195246, -84.5779957],
            'us.kentucky.laurel_county' => [37.0693489, -84.1857115],
            'us.kentucky.lebanon_city' => [37.5697868, -85.2527381],
            'us.kentucky.lebanon_junction_city' => [37.8345086, -85.7319042],
            'us.kentucky.leitchfield_city' => [37.4800544, -86.2938637],
            'us.kentucky.leslie_county' => [37.0698286, -83.3789389],
            'us.kentucky.lewisburg_city' => [36.9864336, -86.9472194],
            'us.kentucky.lincoln_county' => [37.4751264, -84.6479124],
            'us.kentucky.livingston_county' => [37.2431347, -88.362785],
            'us.kentucky.logan_county' => [36.869834, -86.8621827],
            'us.kentucky.ludlow_city' => [39.0925597, -84.5474435],
            'us.kentucky.madison_county' => [37.7143001, -84.3121264],
            'us.kentucky.madisonville_city' => [37.3281005, -87.4988882],
            'us.kentucky.magoffin_county' => [37.730555, -83.0361376],
            'us.kentucky.marion_city' => [37.3328286, -88.0811349],
            'us.kentucky.marion_county' => [37.585137, -85.2308414],
            'us.kentucky.marshall_county' => [36.8573767, -88.4016041],
            'us.kentucky.martin_city' => [37.5728764, -82.752659],
            'us.kentucky.martin_county' => [37.7833756, -82.5185837],
            'us.kentucky.mayfield_city' => [36.7417235, -88.6367154],
            'us.kentucky.maysville_city' => [38.6411854, -83.744365],
            'us.kentucky.mccracken_county' => [37.0330607, -88.7108964],
            'us.kentucky.mccreary_county' => [36.6973499, -84.4802606],
            'us.kentucky.mckee_city' => [37.430364, -83.9979834],
            'us.kentucky.menifee_county' => [37.9335368, -83.634843],
            'us.kentucky.mercer_county' => [37.8258603, -84.8984775],
            'us.kentucky.metcalfe_county' => [37.0032438, -85.643487],
            'us.kentucky.middlesboro_city' => [36.6072567, -83.7142848],
            'us.kentucky.midway_city' => [38.1509077, -84.6838344],
            'us.kentucky.millersburg_city' => [38.30202, -84.1474297],
            'us.kentucky.monroe_county' => [36.7484915, -85.7256372],
            'us.kentucky.montgomery_county' => [38.0314578, -83.8897057],
            'us.kentucky.morehead_city' => [38.1839705, -83.4326841],
            'us.kentucky.morgan_county' => [37.9145713, -83.2934086],
            'us.kentucky.morgantown_city' => [37.2256023, -86.6835998],
            'us.kentucky.mount_olivet_city' => [38.531463, -84.036872],
            'us.kentucky.mount_vernon_city' => [37.3528615, -84.3404919],
            'us.kentucky.mount_washington_city' => [38.0500627, -85.5457877],
            'us.kentucky.muldraugh_city' => [37.9370158, -85.9916308],
            'us.kentucky.munfordville_city' => [37.2722751, -85.8910819],
            'us.kentucky.murray_city' => [36.6103334, -88.314761],
            'us.kentucky.nicholas_county' => [38.3767625, -84.059029],
            'us.kentucky.nicholasville_city' => [37.8806341, -84.5729961],
            'us.kentucky.nortonville_city' => [37.1908777, -87.4527768],
            'us.kentucky.oak_grove_city' => [36.6650471, -87.4427878],
            'us.kentucky.ohio_county' => [37.5108523, -86.8220341],
            'us.kentucky.olive_hill_city' => [38.3000809, -83.1740654],
            'us.kentucky.owensboro_city' => [37.7719074, -87.1111676],
            'us.kentucky.owenton_city' => [38.536456, -84.8418926],
            'us.kentucky.paducah_city' => [37.0833893, -88.6000478],
            'us.kentucky.paintsville_city' => [37.8145384, -82.8071054],
            'us.kentucky.paris_city' => [38.2097987, -84.2529869],
            'us.kentucky.park_city' => [37.0939375, -86.046367],
            'us.kentucky.pendleton_county' => [38.7283386, -84.3962535],
            'us.kentucky.perry_county' => [37.3160706, -83.2077645],
            'us.kentucky.perryville_city' => [37.650351, -84.9516234],
            'us.kentucky.pike_county' => [37.4842087, -82.4752757],
            'us.kentucky.pikeville_city' => [37.4792672, -82.5187629],
            'us.kentucky.pineville_city' => [36.76203, -83.6949176],
            'us.kentucky.pioneer_village_city' => [38.0606219, -85.6777364],
            'us.kentucky.powell_county' => [37.8380647, -83.8260884],
            'us.kentucky.prestonsburg_city' => [37.6656527, -82.7715486],
            'us.kentucky.princeton_city' => [37.1092162, -87.8819594],
            'us.kentucky.pulaski_county' => [37.0853508, -84.5222189],
            'us.kentucky.raceland_city' => [38.5400803, -82.7284976],
            'us.kentucky.radcliff_city' => [37.8403456, -85.9491298],
            'us.kentucky.richmond_city' => [37.7478572, -84.2946539],
            'us.kentucky.robertson_county' => [38.5224338, -84.0378894],
            'us.kentucky.rockcastle_county' => [37.3743065, -84.3121264],
            'us.kentucky.rowan_county' => [38.177068, -83.4643551],
            'us.kentucky.russell_city' => [38.5173028, -82.6976631],
            'us.kentucky.russell_springs_city' => [37.0561788, -85.0885667],
            'us.kentucky.russellville_city' => [36.8453199, -86.887219],
            'us.kentucky.ryland_heights_city' => [38.9575629, -84.4629962],
            'us.kentucky.salyersville_city' => [37.7525922, -83.0687816],
            'us.kentucky.scott_county' => [38.3172, -84.5641],
            'us.kentucky.scottsville_city' => [36.7533781, -86.1905424],
            'us.kentucky.shelby_county' => [38.1778076, -85.2308414],
            'us.kentucky.shelbyville_city' => [38.2120144, -85.2235666],
            'us.kentucky.shepherdsville_city' => [37.9883991, -85.7157924],
            'us.kentucky.shively_city' => [38.2000701, -85.8227413],
            'us.kentucky.silver_grove_city' => [39.0345062, -84.3902174],
            'us.kentucky.simpson_county' => [36.7772014, -86.6207943],
            'us.kentucky.simpsonville_city' => [38.22257, -85.3552349],
            'us.kentucky.somerset_city' => [37.0920222, -84.6041084],
            'us.kentucky.southgate_city' => [39.072005, -84.4727195],
            'us.kentucky.spencer_county' => [38.0123167, -85.3136218],
            'us.kentucky.springfield_city' => [37.6853413, -85.2221819],
            'us.kentucky.st_matthews_city' => [38.2435659, -85.6357789],
            'us.kentucky.stanford_city' => [37.5311901, -84.6618876],
            'us.kentucky.stanton_city' => [37.8456373, -83.8582525],
            'us.kentucky.taylor_county' => [37.332884, -85.3136218],
            'us.kentucky.taylor_mill_city' => [38.9975616, -84.4963305],
            'us.kentucky.taylorsville_city' => [38.0317304, -85.3424533],
            'us.kentucky.todd_county' => [36.8338638, -87.1422895],
            'us.kentucky.tompkinsville_city' => [36.7022797, -85.6916396],
            'us.kentucky.union_county' => [37.6638744, -87.972681],
            'us.kentucky.vanceburg_city' => [38.599243, -83.3187952],
            'us.kentucky.versailles_city' => [38.052576, -84.7299464],
            'us.kentucky.villa_hills_city' => [39.0633933, -84.5929998],
            'us.kentucky.vine_grove_city' => [37.8100674, -85.9813524],
            'us.kentucky.warren_county' => [36.9886043, -86.4996546],
            'us.kentucky.warsaw_city' => [38.7833963, -84.9016151],
            'us.kentucky.washington_county' => [37.7516142, -85.1479364],
            'us.kentucky.wayne_county' => [36.7571907, -84.8567932],
            'us.kentucky.west_buechel_city' => [38.197014, -85.6632938],
            'us.kentucky.west_liberty_city' => [37.9214758, -83.2596216],
            'us.kentucky.west_point_city' => [37.9995164, -85.9435746],
            'us.kentucky.whitesburg_city' => [37.1184318, -82.8268265],
            'us.kentucky.whitley_county' => [36.726335, -84.1857115],
            'us.kentucky.wilmore_city' => [37.8620226, -84.6616105],
            'us.kentucky.winchester_city' => [37.990079, -84.1796503],
            'us.kentucky.wolfe_county' => [37.7550869, -83.4643551],
            'us.kentucky.woodford_county' => [38.0721662, -84.7315563],
            'us.kentucky.wurtland_city' => [38.5503577, -82.7779437],
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
            'us.nevada' => [39.1641, -119.7661],
            'us.new_jersey' => [40.2206, -74.7597],
            'us.new_jersey.newark' => [40.7357, -74.1724],
            'us.new_mexico' => [34.5199, -105.8701],
            'us.new_york' => [40.7128, -74.0060],
            'us.new_york.yonkers' => [40.9312, -73.8987],
            'us.north_carolina' => [35.7596, -79.0193],
            'us.ohio' => [40.4173, -82.9071],
            'us.oklahoma' => [35.4676, -97.5164],
            'us.tennessee' => [35.5175, -86.5804],
            'us.texas' => [31.9686, -99.9018],
            'us.virginia' => [37.5407, -77.4360],
            'us.washingtondc' => [38.9072, -77.0369],
            'us.west_virginia' => [38.3498, -81.6326],
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
