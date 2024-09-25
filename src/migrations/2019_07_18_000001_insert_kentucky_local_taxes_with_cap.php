<?php

use Appleton\Taxes\Countries\US\Kentucky\AlexandriaCity\AlexandriaCity;
use Appleton\Taxes\Countries\US\Kentucky\AugustaCity\AugustaCity;
use Appleton\Taxes\Countries\US\Kentucky\BrooksvilleCity\BrooksvilleCity;
use Appleton\Taxes\Countries\US\Kentucky\BurkesvilleCity\BurkesvilleCity;
use Appleton\Taxes\Countries\US\Kentucky\CampbellCounty\CampbellCounty;
use Appleton\Taxes\Countries\US\Kentucky\ClintonCity\ClintonCity;
use Appleton\Taxes\Countries\US\Kentucky\ColdSpringCity\ColdSpringCity;
use Appleton\Taxes\Countries\US\Kentucky\CovingtonCity\CovingtonCity;
use Appleton\Taxes\Countries\US\Kentucky\CrestviewHillsCity\CrestviewHillsCity;
use Appleton\Taxes\Countries\US\Kentucky\CumberlandCounty\CumberlandCounty;
use Appleton\Taxes\Countries\US\Kentucky\CumberlandSchoolCounty\CumberlandSchoolCounty;
use Appleton\Taxes\Countries\US\Kentucky\FortWrightCity\FortWrightCity;
use Appleton\Taxes\Countries\US\Kentucky\HighlandHeightsCity\HighlandHeightsCity;
use Appleton\Taxes\Countries\US\Kentucky\McLeanCounty\McLeanCounty;
use Appleton\Taxes\Countries\US\Kentucky\NelsonCounty\NelsonCounty;
use Appleton\Taxes\Countries\US\Kentucky\NewportCity\NewportCity;
use Appleton\Taxes\Countries\US\Kentucky\ParkHillsCity\ParkHillsCity;
use Appleton\Taxes\Countries\US\Kentucky\RussellCounty\RussellCounty;
use Appleton\Taxes\Countries\US\Kentucky\WilderCity\WilderCity;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    private const STATE_FILE = '2019_07_18_000000_insert_kentucky_local_taxes_with_cap.ini';

    private const CLASSES = [
        'Alexandria City' => AlexandriaCity::class,
        'Augusta City' => AugustaCity::class,
        'Brooksville City' => BrooksvilleCity::class,
        'Burkesville City' => BurkesvilleCity::class,
        'Campbell County' => CampbellCounty::class,
        'Clinton City' => ClintonCity::class,
        'Cold Spring City' => ColdSpringCity::class,
        'Covington City' => CovingtonCity::class,
        'Crestview Hills City' => CrestviewHillsCity::class,
        'Cumberland County' => CumberlandCounty::class,
        'Cumberland School County' => CumberlandSchoolCounty::class,
        'Fort Wright City' => FortWrightCity::class,
        'Highland Heights City' => HighlandHeightsCity::class,
        'McLean County' => McLeanCounty::class,
        'Nelson County' => NelsonCounty::class,
        'Newport City' => NewportCity::class,
        'Park Hills City' => ParkHillsCity::class,
        'Russell County' => RussellCounty::class,
        'Wilder City' => WilderCity::class,
    ];

    public function up()
    {
        foreach (parse_ini_file(self::STATE_FILE) as $name => $geo) {
            $tax_id = DB::table('taxes')->insertGetId([
                'name' => $name.' Kentucky Tax',
                'class' => self::CLASSES[$name],
            ]);

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
};
