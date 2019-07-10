<?php

use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertKentuckyLocalTaxesWithoutCap extends Migration
{
    private const STATE_FILE = '2019_07_08_000001_insert_kentucky_local_taxes_without_cap.ini';

    private const CLASSES = [
        'Adairville City' => Appleton\Taxes\Countries\US\Kentucky\AdairvilleCity\AdairvilleCity::class,
        'Allen County' => Appleton\Taxes\Countries\US\Kentucky\AllenCounty\AllenCounty::class,
        'Ashland City' => Appleton\Taxes\Countries\US\Kentucky\AshlandCity\AshlandCity::class,
        'Auburn City' => Appleton\Taxes\Countries\US\Kentucky\AuburnCity\AuburnCity::class,
        'Ballard County' => Appleton\Taxes\Countries\US\Kentucky\BallardCounty\BallardCounty::class,
        'Bardstown City' => Appleton\Taxes\Countries\US\Kentucky\BardstownCity\BardstownCity::class,
        'Bardwell City' => Appleton\Taxes\Countries\US\Kentucky\BardwellCity\BardwellCity::class,
        'Bath County' => Appleton\Taxes\Countries\US\Kentucky\BathCounty\BathCounty::class,
        'Beattyville City' => Appleton\Taxes\Countries\US\Kentucky\BeattyvilleCity\BeattyvilleCity::class,
        'Bellevue City' => Appleton\Taxes\Countries\US\Kentucky\BellevueCity\BellevueCity::class,
        'Benton City' => Appleton\Taxes\Countries\US\Kentucky\BentonCity\BentonCity::class,
        'Berea City' => Appleton\Taxes\Countries\US\Kentucky\BereaCity\BereaCity::class,
        'Bourbon County' => Appleton\Taxes\Countries\US\Kentucky\BourbonCounty\BourbonCounty::class,
        'Bowling Green City' => Appleton\Taxes\Countries\US\Kentucky\BowlingGreenCity\BowlingGreenCity::class,
        'Boyd County' => Appleton\Taxes\Countries\US\Kentucky\BoydCounty\BoydCounty::class,
        'Boyle County' => Appleton\Taxes\Countries\US\Kentucky\BoyleCounty\BoyleCounty::class,
        'Breathitt County' => Appleton\Taxes\Countries\US\Kentucky\BreathittCounty\BreathittCounty::class,
        'Brodhead City' => Appleton\Taxes\Countries\US\Kentucky\BrodheadCity\BrodheadCity::class,
        'Bromley City' => Appleton\Taxes\Countries\US\Kentucky\BromleyCity\BromleyCity::class,
        'Brownsville City' => Appleton\Taxes\Countries\US\Kentucky\BrownsvilleCity\BrownsvilleCity::class,
        'Butler County' => Appleton\Taxes\Countries\US\Kentucky\ButlerCounty\ButlerCounty::class,
        'Cadiz City' => Appleton\Taxes\Countries\US\Kentucky\CadizCity\CadizCity::class,
        'Caldwell County' => Appleton\Taxes\Countries\US\Kentucky\CaldwellCounty\CaldwellCounty::class,
        'Calvert City' => Appleton\Taxes\Countries\US\Kentucky\CalvertCity\CalvertCity::class,
        'Camargo City' => Appleton\Taxes\Countries\US\Kentucky\CamargoCity\CamargoCity::class,
        'Campbellsville City' => Appleton\Taxes\Countries\US\Kentucky\CampbellsvilleCity\CampbellsvilleCity::class,
        'Carlisle City' => Appleton\Taxes\Countries\US\Kentucky\CarlisleCity\CarlisleCity::class,
        'Catlettsburg City' => Appleton\Taxes\Countries\US\Kentucky\CatlettsburgCity\CatlettsburgCity::class,
        'Cave City' => Appleton\Taxes\Countries\US\Kentucky\CaveCity\CaveCity::class,
        'Clark County' => Appleton\Taxes\Countries\US\Kentucky\ClarkCounty\ClarkCounty::class,
        'Clarkson City' => Appleton\Taxes\Countries\US\Kentucky\ClarksonCity\ClarksonCity::class,
        'Clay City' => Appleton\Taxes\Countries\US\Kentucky\ClayCity\ClayCity::class,
        'Clay County' => Appleton\Taxes\Countries\US\Kentucky\ClayCounty\ClayCounty::class,
        'Clinton County' => Appleton\Taxes\Countries\US\Kentucky\ClintonCounty\ClintonCounty::class,
        'Coal Run Village City' => Appleton\Taxes\Countries\US\Kentucky\CoalRunVillageCity\CoalRunVillageCity::class,
        'Crescent Springs City' => Appleton\Taxes\Countries\US\Kentucky\CrescentSpringsCity\CrescentSpringsCity::class,
        'Crittenden County' => Appleton\Taxes\Countries\US\Kentucky\CrittendenCounty\CrittendenCounty::class,
        'Cynthiana City' => Appleton\Taxes\Countries\US\Kentucky\CynthianaCity\CynthianaCity::class,
        'Danville City' => Appleton\Taxes\Countries\US\Kentucky\DanvilleCity\DanvilleCity::class,
        'Daviess County' => Appleton\Taxes\Countries\US\Kentucky\DaviessCounty\DaviessCounty::class,
        'Dawson Springs City' => Appleton\Taxes\Countries\US\Kentucky\DawsonSpringsCity\DawsonSpringsCity::class,
        'Dayton City' => Appleton\Taxes\Countries\US\Kentucky\DaytonCity\DaytonCity::class,
        'Dry Ridge City' => Appleton\Taxes\Countries\US\Kentucky\DryRidgeCity\DryRidgeCity::class,
        'Earlington City' => Appleton\Taxes\Countries\US\Kentucky\EarlingtonCity\EarlingtonCity::class,
        'Eddyville City' => Appleton\Taxes\Countries\US\Kentucky\EddyvilleCity\EddyvilleCity::class,
        'Edgewood City' => Appleton\Taxes\Countries\US\Kentucky\EdgewoodCity\EdgewoodCity::class,
        'Edmonton City' => Appleton\Taxes\Countries\US\Kentucky\EdmontonCity\EdmontonCity::class,
        'Elizabethtown City' => Appleton\Taxes\Countries\US\Kentucky\ElizabethtownCity\ElizabethtownCity::class,
        'Elkhorn City' => Appleton\Taxes\Countries\US\Kentucky\ElkhornCity\ElkhornCity::class,
        'Elkton City' => Appleton\Taxes\Countries\US\Kentucky\ElktonCity\ElktonCity::class,
        'Elsmere City' => Appleton\Taxes\Countries\US\Kentucky\ElsmereCity\ElsmereCity::class,
        'Eminence City' => Appleton\Taxes\Countries\US\Kentucky\EminenceCity\EminenceCity::class,
        'Erlanger City' => Appleton\Taxes\Countries\US\Kentucky\ErlangerCity\ErlangerCity::class,
        'Estill County' => Appleton\Taxes\Countries\US\Kentucky\EstillCounty\EstillCounty::class,
        'Fayette County' => '',
        'Fayette County School District' => Appleton\Taxes\Countries\US\Kentucky\FayetteCountySchoolDistrict\FayetteCountySchoolDistrict::class,
        'Flemingsburg City' => Appleton\Taxes\Countries\US\Kentucky\FlemingsburgCity\FlemingsburgCity::class,
        'Fort Mitchell City' => Appleton\Taxes\Countries\US\Kentucky\FortMitchellCity\FortMitchellCity::class,
        'Fort Thomas City' => Appleton\Taxes\Countries\US\Kentucky\FortThomasCity\FortThomasCity::class,
        'Frankfort City' => Appleton\Taxes\Countries\US\Kentucky\FrankfortCity\FrankfortCity::class,
        'Franklin City' => Appleton\Taxes\Countries\US\Kentucky\FranklinCity\FranklinCity::class,
        'Franklin County' => Appleton\Taxes\Countries\US\Kentucky\FranklinCounty\FranklinCounty::class,
        'Fulton City' => Appleton\Taxes\Countries\US\Kentucky\FultonCity\FultonCity::class,
        'Gallatin County' => Appleton\Taxes\Countries\US\Kentucky\GallatinCounty\GallatinCounty::class,
        'Garrard County' => Appleton\Taxes\Countries\US\Kentucky\GarrardCounty\GarrardCounty::class,
        'Glasgow City' => Appleton\Taxes\Countries\US\Kentucky\GlasgowCity\GlasgowCity::class,
        'Grant County' => Appleton\Taxes\Countries\US\Kentucky\GrantCounty\GrantCounty::class,
        'Graves County' => Appleton\Taxes\Countries\US\Kentucky\GravesCounty\GravesCounty::class,
        'Grayson City' => Appleton\Taxes\Countries\US\Kentucky\GraysonCity\GraysonCity::class,
        'Grayson County' => Appleton\Taxes\Countries\US\Kentucky\GraysonCounty\GraysonCounty::class,
        'Greensburg City' => Appleton\Taxes\Countries\US\Kentucky\GreensburgCity\GreensburgCity::class,
        'Greenup City' => Appleton\Taxes\Countries\US\Kentucky\GreenupCity\GreenupCity::class,
        'Guthrie City' => Appleton\Taxes\Countries\US\Kentucky\GuthrieCity\GuthrieCity::class,
        'Hancock County' => Appleton\Taxes\Countries\US\Kentucky\HancockCounty\HancockCounty::class,
        'Harrison County' => Appleton\Taxes\Countries\US\Kentucky\HarrisonCounty\HarrisonCounty::class,
        'Harrodsburg City' => Appleton\Taxes\Countries\US\Kentucky\HarrodsburgCity\HarrodsburgCity::class,
        'Hartford City' => Appleton\Taxes\Countries\US\Kentucky\HartfordCity\HartfordCity::class,
        'Hart County' => Appleton\Taxes\Countries\US\Kentucky\HartCounty\HartCounty::class,
        'Henderson City' => Appleton\Taxes\Countries\US\Kentucky\HendersonCity\HendersonCity::class,
        'Henderson County' => Appleton\Taxes\Countries\US\Kentucky\HendersonCounty\HendersonCounty::class,
        'Hickman City' => Appleton\Taxes\Countries\US\Kentucky\HickmanCity\HickmanCity::class,
        'Hickman County' => Appleton\Taxes\Countries\US\Kentucky\HickmanCounty\HickmanCounty::class,
        'Hillview City' => Appleton\Taxes\Countries\US\Kentucky\HillviewCity\HillviewCity::class,
        'Hodgenville City' => Appleton\Taxes\Countries\US\Kentucky\HodgenvilleCity\HodgenvilleCity::class,
        'Hopkinsville City' => Appleton\Taxes\Countries\US\Kentucky\HopkinsvilleCity\HopkinsvilleCity::class,
        'Hopkins County' => Appleton\Taxes\Countries\US\Kentucky\HopkinsCounty\HopkinsCounty::class,
        'Horse Cave City' => Appleton\Taxes\Countries\US\Kentucky\HorseCaveCity\HorseCaveCity::class,
        'Independence City' => Appleton\Taxes\Countries\US\Kentucky\IndependenceCity\IndependenceCity::class,
        'Jackson City' => Appleton\Taxes\Countries\US\Kentucky\JacksonCity\JacksonCity::class,
        'Jackson County' => Appleton\Taxes\Countries\US\Kentucky\JacksonCounty\JacksonCounty::class,
        'Jamestown City' => Appleton\Taxes\Countries\US\Kentucky\JamestownCity\JamestownCity::class,
        'Jeffersontown City' => Appleton\Taxes\Countries\US\Kentucky\JeffersontownCity\JeffersontownCity::class,
        'Jeffersonville City' => Appleton\Taxes\Countries\US\Kentucky\JeffersonvilleCity\JeffersonvilleCity::class,
        'Jessamine County' => Appleton\Taxes\Countries\US\Kentucky\JessamineCounty\JessamineCounty::class,
        'Johnson County' => Appleton\Taxes\Countries\US\Kentucky\JohnsonCounty\JohnsonCounty::class,
        'Junction City' => Appleton\Taxes\Countries\US\Kentucky\JunctionCity\JunctionCity::class,
        'Knox County' => Appleton\Taxes\Countries\US\Kentucky\KnoxCounty\KnoxCounty::class,
        'La Grange City' => Appleton\Taxes\Countries\US\Kentucky\LaGrangeCity\LaGrangeCity::class,
        'Lakeside Park City' => Appleton\Taxes\Countries\US\Kentucky\LakesideParkCity\LakesideParkCity::class,
        'Lancaster City' => Appleton\Taxes\Countries\US\Kentucky\LancasterCity\LancasterCity::class,
        'Laurel County' => Appleton\Taxes\Countries\US\Kentucky\LaurelCounty\LaurelCounty::class,
        'Lebanon City' => Appleton\Taxes\Countries\US\Kentucky\LebanonCity\LebanonCity::class,
        'Lebanon Junction City' => Appleton\Taxes\Countries\US\Kentucky\LebanonJunctionCity\LebanonJunctionCity::class,
        'Leitchfield City' => Appleton\Taxes\Countries\US\Kentucky\LeitchfieldCity\LeitchfieldCity::class,
        'Leslie County' => Appleton\Taxes\Countries\US\Kentucky\LeslieCounty\LeslieCounty::class,
        'Lewisburg City' => Appleton\Taxes\Countries\US\Kentucky\LewisburgCity\LewisburgCity::class,
        'Lexington-Fayette Urban County' => Appleton\Taxes\Countries\US\Kentucky\LexingtonFayetteUrbanCounty\LexingtonFayetteUrbanCounty::class,
        'Lincoln County' => Appleton\Taxes\Countries\US\Kentucky\LincolnCounty\LincolnCounty::class,
        'Livingston County' => Appleton\Taxes\Countries\US\Kentucky\LivingstonCounty\LivingstonCounty::class,
        'Logan County' => Appleton\Taxes\Countries\US\Kentucky\LoganCounty\LoganCounty::class,
        'Ludlow City' => Appleton\Taxes\Countries\US\Kentucky\LudlowCity\LudlowCity::class,
        'Madison County' => Appleton\Taxes\Countries\US\Kentucky\MadisonCounty\MadisonCounty::class,
        'Madisonville City' => Appleton\Taxes\Countries\US\Kentucky\MadisonvilleCity\MadisonvilleCity::class,
        'Magoffin County' => Appleton\Taxes\Countries\US\Kentucky\MagoffinCounty\MagoffinCounty::class,
        'Marion City' => Appleton\Taxes\Countries\US\Kentucky\MarionCity\MarionCity::class,
        'Marion County' => Appleton\Taxes\Countries\US\Kentucky\MarionCounty\MarionCounty::class,
        'Marshall County' => Appleton\Taxes\Countries\US\Kentucky\MarshallCounty\MarshallCounty::class,
        'Martin City' => Appleton\Taxes\Countries\US\Kentucky\MartinCity\MartinCity::class,
        'Martin County' => Appleton\Taxes\Countries\US\Kentucky\MartinCounty\MartinCounty::class,
        'Mayfield City' => Appleton\Taxes\Countries\US\Kentucky\MayfieldCity\MayfieldCity::class,
        'Maysville City' => Appleton\Taxes\Countries\US\Kentucky\MaysvilleCity\MaysvilleCity::class,
        'McCracken County' => Appleton\Taxes\Countries\US\Kentucky\McCrackenCounty\McCrackenCounty::class,
        'McCreary County' => Appleton\Taxes\Countries\US\Kentucky\McCrearyCounty\McCrearyCounty::class,
        'McKee City' => Appleton\Taxes\Countries\US\Kentucky\McKeeCity\McKeeCity::class,
        'Menifee County' => Appleton\Taxes\Countries\US\Kentucky\MenifeeCounty\MenifeeCounty::class,
        'Mercer County' => Appleton\Taxes\Countries\US\Kentucky\MercerCounty\MercerCounty::class,
        'Metcalfe County' => Appleton\Taxes\Countries\US\Kentucky\MetcalfeCounty\MetcalfeCounty::class,
        'Middlesboro City' => Appleton\Taxes\Countries\US\Kentucky\MiddlesboroCity\MiddlesboroCity::class,
        'Midway City' => Appleton\Taxes\Countries\US\Kentucky\MidwayCity\MidwayCity::class,
        'Millersburg City' => Appleton\Taxes\Countries\US\Kentucky\MillersburgCity\MillersburgCity::class,
        'Monroe County' => Appleton\Taxes\Countries\US\Kentucky\MonroeCounty\MonroeCounty::class,
        'Montgomery County' => Appleton\Taxes\Countries\US\Kentucky\MontgomeryCounty\MontgomeryCounty::class,
        'Morehead City' => Appleton\Taxes\Countries\US\Kentucky\MoreheadCity\MoreheadCity::class,
        'Morgan County' => Appleton\Taxes\Countries\US\Kentucky\MorganCounty\MorganCounty::class,
        'Morgantown City' => Appleton\Taxes\Countries\US\Kentucky\MorgantownCity\MorgantownCity::class,
        'Mount Olivet City' => Appleton\Taxes\Countries\US\Kentucky\MountOlivetCity\MountOlivetCity::class,
        'Mount Vernon City' => Appleton\Taxes\Countries\US\Kentucky\MountVernonCity\MountVernonCity::class,
        'Mount Washington City' => Appleton\Taxes\Countries\US\Kentucky\MountWashingtonCity\MountWashingtonCity::class,
        'Muldraugh City' => Appleton\Taxes\Countries\US\Kentucky\MuldraughCity\MuldraughCity::class,
        'Munfordville City' => Appleton\Taxes\Countries\US\Kentucky\MunfordvilleCity\MunfordvilleCity::class,
        'Murray City' => Appleton\Taxes\Countries\US\Kentucky\MurrayCity\MurrayCity::class,
        'Nicholas County' => Appleton\Taxes\Countries\US\Kentucky\NicholasCounty\NicholasCounty::class,
        'Nicholasville City' => Appleton\Taxes\Countries\US\Kentucky\NicholasvilleCity\NicholasvilleCity::class,
        'Nortonville City' => Appleton\Taxes\Countries\US\Kentucky\NortonvilleCity\NortonvilleCity::class,
        'Oak Grove City' => Appleton\Taxes\Countries\US\Kentucky\OakGroveCity\OakGroveCity::class,
        'Ohio County' => Appleton\Taxes\Countries\US\Kentucky\OhioCounty\OhioCounty::class,
        'Olive Hill City' => Appleton\Taxes\Countries\US\Kentucky\OliveHillCity\OliveHillCity::class,
        'Owensboro City' => Appleton\Taxes\Countries\US\Kentucky\OwensboroCity\OwensboroCity::class,
        'Owenton City' => Appleton\Taxes\Countries\US\Kentucky\OwentonCity\OwentonCity::class,
        'Paducah City' => Appleton\Taxes\Countries\US\Kentucky\PaducahCity\PaducahCity::class,
        'Paintsville City' => Appleton\Taxes\Countries\US\Kentucky\PaintsvilleCity\PaintsvilleCity::class,
        'Paris City' => Appleton\Taxes\Countries\US\Kentucky\ParisCity\ParisCity::class,
        'Park City' => Appleton\Taxes\Countries\US\Kentucky\ParkCity\ParkCity::class,
        'Pendleton County' => Appleton\Taxes\Countries\US\Kentucky\PendletonCounty\PendletonCounty::class,
        'Perryville City' => Appleton\Taxes\Countries\US\Kentucky\PerryvilleCity\PerryvilleCity::class,
        'Perry County' => Appleton\Taxes\Countries\US\Kentucky\PerryCounty\PerryCounty::class,
        'Pike County' => Appleton\Taxes\Countries\US\Kentucky\PikeCounty\PikeCounty::class,
        'Pikeville City' => Appleton\Taxes\Countries\US\Kentucky\PikevilleCity\PikevilleCity::class,
        'Pineville City' => Appleton\Taxes\Countries\US\Kentucky\PinevilleCity\PinevilleCity::class,
        'Pioneer Village City' => Appleton\Taxes\Countries\US\Kentucky\PioneerVillageCity\PioneerVillageCity::class,
        'Powell County' => Appleton\Taxes\Countries\US\Kentucky\PowellCounty\PowellCounty::class,
        'Prestonsburg City' => Appleton\Taxes\Countries\US\Kentucky\PrestonsburgCity\PrestonsburgCity::class,
        'Princeton City' => Appleton\Taxes\Countries\US\Kentucky\PrincetonCity\PrincetonCity::class,
        'Pulaski County' => Appleton\Taxes\Countries\US\Kentucky\PulaskiCounty\PulaskiCounty::class,
        'Raceland City' => Appleton\Taxes\Countries\US\Kentucky\RacelandCity\RacelandCity::class,
        'Radcliff City' => Appleton\Taxes\Countries\US\Kentucky\RadcliffCity\RadcliffCity::class,
        'Richmond City' => Appleton\Taxes\Countries\US\Kentucky\RichmondCity\RichmondCity::class,
        'Robertson County' => Appleton\Taxes\Countries\US\Kentucky\RobertsonCounty\RobertsonCounty::class,
        'Rockcastle County' => Appleton\Taxes\Countries\US\Kentucky\RockcastleCounty\RockcastleCounty::class,
        'Rowan County' => Appleton\Taxes\Countries\US\Kentucky\RowanCounty\RowanCounty::class,
        'Russell City' => Appleton\Taxes\Countries\US\Kentucky\RussellCity\RussellCity::class,
        'Russell Springs City' => Appleton\Taxes\Countries\US\Kentucky\RussellSpringsCity\RussellSpringsCity::class,
        'Russellville City' => Appleton\Taxes\Countries\US\Kentucky\RussellvilleCity\RussellvilleCity::class,
        'Ryland Heights City' => Appleton\Taxes\Countries\US\Kentucky\RylandHeightsCity\RylandHeightsCity::class,
        'St. Matthews City' => Appleton\Taxes\Countries\US\Kentucky\StMatthewsCity\StMatthewsCity::class,
        'Salyersville City' => Appleton\Taxes\Countries\US\Kentucky\SalyersvilleCity\SalyersvilleCity::class,
        'Scottsville City' => Appleton\Taxes\Countries\US\Kentucky\ScottsvilleCity\ScottsvilleCity::class,
        'Shelby County' => Appleton\Taxes\Countries\US\Kentucky\ShelbyCounty\ShelbyCounty::class,
        'Shelbyville City' => Appleton\Taxes\Countries\US\Kentucky\ShelbyvilleCity\ShelbyvilleCity::class,
        'Shepherdsville City' => Appleton\Taxes\Countries\US\Kentucky\ShepherdsvilleCity\ShepherdsvilleCity::class,
        'Shively City' => Appleton\Taxes\Countries\US\Kentucky\ShivelyCity\ShivelyCity::class,
        'Silver Grove City' => Appleton\Taxes\Countries\US\Kentucky\SilverGroveCity\SilverGroveCity::class,
        'Simpson County' => Appleton\Taxes\Countries\US\Kentucky\SimpsonCounty\SimpsonCounty::class,
        'Simpsonville City' => Appleton\Taxes\Countries\US\Kentucky\SimpsonvilleCity\SimpsonvilleCity::class,
        'Southgate City' => Appleton\Taxes\Countries\US\Kentucky\SouthgateCity\SouthgateCity::class,
        'Spencer County' => Appleton\Taxes\Countries\US\Kentucky\SpencerCounty\SpencerCounty::class,
        'Springfield City' => Appleton\Taxes\Countries\US\Kentucky\SpringfieldCity\SpringfieldCity::class,
        'Stanford City' => Appleton\Taxes\Countries\US\Kentucky\StanfordCity\StanfordCity::class,
        'Stanton City' => Appleton\Taxes\Countries\US\Kentucky\StantonCity\StantonCity::class,
        'Taylor County' => Appleton\Taxes\Countries\US\Kentucky\TaylorCounty\TaylorCounty::class,
        'Taylor Mill City' => Appleton\Taxes\Countries\US\Kentucky\TaylorMillCity\TaylorMillCity::class,
        'Taylorsville City' => Appleton\Taxes\Countries\US\Kentucky\TaylorsvilleCity\TaylorsvilleCity::class,
        'Todd County' => Appleton\Taxes\Countries\US\Kentucky\ToddCounty\ToddCounty::class,
        'Tompkinsville City' => Appleton\Taxes\Countries\US\Kentucky\TompkinsvilleCity\TompkinsvilleCity::class,
        'Union County' => Appleton\Taxes\Countries\US\Kentucky\UnionCounty\UnionCounty::class,
        'Vanceburg City' => Appleton\Taxes\Countries\US\Kentucky\VanceburgCity\VanceburgCity::class,
        'Versailles City' => Appleton\Taxes\Countries\US\Kentucky\VersaillesCity\VersaillesCity::class,
        'Villa Hills City' => Appleton\Taxes\Countries\US\Kentucky\VillaHillsCity\VillaHillsCity::class,
        'Vine Grove City' => Appleton\Taxes\Countries\US\Kentucky\VineGroveCity\VineGroveCity::class,
        'Warren County' => Appleton\Taxes\Countries\US\Kentucky\WarrenCounty\WarrenCounty::class,
        'Warren County School District' => Appleton\Taxes\Countries\US\Kentucky\WarrenCountySchoolDistrict\WarrenCountySchoolDistrict::class,
        'Warsaw City' => Appleton\Taxes\Countries\US\Kentucky\WarsawCity\WarsawCity::class,
        'Washington County' => Appleton\Taxes\Countries\US\Kentucky\WashingtonCounty\WashingtonCounty::class,
        'Wayne County' => Appleton\Taxes\Countries\US\Kentucky\WayneCounty\WayneCounty::class,
        'West Buechel City' => Appleton\Taxes\Countries\US\Kentucky\WestBuechelCity\WestBuechelCity::class,
        'West Liberty City' => Appleton\Taxes\Countries\US\Kentucky\WestLibertyCity\WestLibertyCity::class,
        'West Point City' => Appleton\Taxes\Countries\US\Kentucky\WestPointCity\WestPointCity::class,
        'Whitesburg City' => Appleton\Taxes\Countries\US\Kentucky\WhitesburgCity\WhitesburgCity::class,
        'Whitley County' => Appleton\Taxes\Countries\US\Kentucky\WhitleyCounty\WhitleyCounty::class,
        'Wilmore City' => Appleton\Taxes\Countries\US\Kentucky\WilmoreCity\WilmoreCity::class,
        'Winchester City' => Appleton\Taxes\Countries\US\Kentucky\WinchesterCity\WinchesterCity::class,
        'Wolfe County' => Appleton\Taxes\Countries\US\Kentucky\WolfeCounty\WolfeCounty::class,
        'Woodford County' => Appleton\Taxes\Countries\US\Kentucky\WoodfordCounty\WoodfordCounty::class,
        'Wurtland City' => Appleton\Taxes\Countries\US\Kentucky\WurtlandCity\WurtlandCity::class,
        'Somerset City' => Appleton\Taxes\Countries\US\Kentucky\SomersetCity\SomersetCity::class,
    ];

    public function up()
    {
        foreach (parse_ini_file(self::STATE_FILE) as $name => $geo) {
            $tax_id = DB::table('taxes')->insertGetId([
                'name' => $name.' Kentucky Tax',
                'class' => self::CLASSES[$name],
            ]);

            if ($name === 'Fayette County') {
                DB::table('governmental_unit_areas')->insertGetId([
                    'name' => $name.', KY',
                    'area' => $geo
                ]);
                continue;
            }

            if ($name === 'Fayette County School District') {
                $fayette_county_gua_id = DB::table('governmental_unit_areas')
                    ->where('name', 'Fayette County, KY')
                    ->first()
                    ->id;

                DB::table('tax_areas')->insert([[
                    'tax_id' => $tax_id,
                    'home_governmental_unit_area_id' => $fayette_county_gua_id,
                    'work_governmental_unit_area_id' => $fayette_county_gua_id,
                    'based' => TaxArea::BASED_ON_BOTH_LOCATIONS,
                ]]);
                continue;
            }

            if ($name === 'Warren County School District') {
                $warren_county_gua_id = DB::table('governmental_unit_areas')
                    ->where('name', 'Warren County, KY')
                    ->first()
                    ->id;

                DB::table('tax_areas')->insert([[
                    'tax_id' => $tax_id,
                    'home_governmental_unit_area_id' => $warren_county_gua_id,
                    'work_governmental_unit_area_id' => $warren_county_gua_id,
                    'based' => TaxArea::BASED_ON_BOTH_LOCATIONS,
                ]]);
                continue;
            }

            if ($name === 'Lexington-Fayette Urban County') {
                $fayette_county_gua_id = DB::table('governmental_unit_areas')
                    ->where('name', 'Fayette County, KY')
                    ->first()
                    ->id;

                DB::table('tax_areas')->insert([[
                    'tax_id' => $tax_id,
                    'work_governmental_unit_area_id' => $fayette_county_gua_id,
                    'based' => TaxArea::BASED_ON_WORK_LOCATION,
                ]]);
                continue;
            }

            $area_id = DB::table('governmental_unit_areas')->insertGetId([
                'name' => $name.', KY',
                'area' => $geo
            ]);

            DB::table('tax_areas')->insert([[
                'tax_id' => $tax_id,
                'work_governmental_unit_area_id' => $area_id,
                'based' => TaxArea::BASED_ON_WORK_LOCATION,
            ]]);
        }
    }
}
