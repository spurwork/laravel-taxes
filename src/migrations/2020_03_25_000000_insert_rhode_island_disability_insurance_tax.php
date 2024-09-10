<?php

use Appleton\Taxes\Countries\US\RhodeIsland\RhodeIslandDisabilityInsurance\RhodeIslandDisabilityInsurance;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    protected $governmental_unit_areas = 'governmental_unit_areas';
    protected $tax_areas = 'tax_areas';

    public function up()
    {
        $gua_id = DB::table($this->governmental_unit_areas)->where('name', 'Rhode Island')->first()->id;

        $ri_disability_insurance_id = DB::table('taxes')->insertGetId([
            'name' => 'Rhode Island Disability Insurance Tax',
            'class' => RhodeIslandDisabilityInsurance::class,
        ]);

        DB::table($this->tax_areas)->insert([[
            'tax_id' => $ri_disability_insurance_id,
            'work_governmental_unit_area_id' => $gua_id,
            'based' => TaxArea::BASED_ON_WORK_LOCATION,
        ]]);
    }
};
