<?php

use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertKentuckyLocalTaxesWithCap extends Migration
{
    private const STATE_FILE = '2019_07_18_000000_insert_kentucky_local_taxes_with_cap.ini';

    private const CLASSES = [
        'Alexandria City' => Appleton\Taxes\Countries\US\Kentucky\AlexandriaCity\AlexandriaCity::class,
        'Augusta City' => Appleton\Taxes\Countries\US\Kentucky\AugustaCity\AugustaCity::class,
        'Brooksville City' => Appleton\Taxes\Countries\US\Kentucky\BrooksvilleCity\BrooksvilleCity::class,
        'Burkesville City' => Appleton\Taxes\Countries\US\Kentucky\BurkesvilleCity\BurkesvilleCity::class,
        'Campbell County' => Appleton\Taxes\Countries\US\Kentucky\CampbellCounty\CampbellCounty::class,
        'Clinton City' => Appleton\Taxes\Countries\US\Kentucky\ClintonCity\ClintonCity::class,
        'Cold Spring City' => Appleton\Taxes\Countries\US\Kentucky\ColdSpringCity\ColdSpringCity::class,
        'Covington City' => Appleton\Taxes\Countries\US\Kentucky\CovingtonCity\CovingtonCity::class,
        'Crestview Hills City' => Appleton\Taxes\Countries\US\Kentucky\CrestviewHillsCity\CrestviewHillsCity::class,
        'Cumberland County' => Appleton\Taxes\Countries\US\Kentucky\CumberlandCounty\CumberlandCounty::class,
        'Cumberland School County' => Appleton\Taxes\Countries\US\Kentucky\CumberlandSchoolCounty\CumberlandSchoolCounty::class,
        'Fort Wright City' => Appleton\Taxes\Countries\US\Kentucky\FortWrightCity\FortWrightCity::class,
        'Highland Heights City' => Appleton\Taxes\Countries\US\Kentucky\HighlandHeightsCity\HighlandHeightsCity::class,
        'McLean County' => Appleton\Taxes\Countries\US\Kentucky\McLeanCounty\McLeanCounty::class,
        'Nelson County' => Appleton\Taxes\Countries\US\Kentucky\NelsonCounty\NelsonCounty::class,
        'Newport City' => Appleton\Taxes\Countries\US\Kentucky\NewportCity\NewportCity::class,
        'Park Hills City' => Appleton\Taxes\Countries\US\Kentucky\ParkHillsCity\ParkHillsCity::class,
        'Russell County' => Appleton\Taxes\Countries\US\Kentucky\RussellCounty\RussellCounty::class,
        'Wilder City' => Appleton\Taxes\Countries\US\Kentucky\WilderCity\WilderCity::class,
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
}
