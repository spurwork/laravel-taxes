<?php

use Appleton\Taxes\Countries\US\NewYork\NewYorkFamilyMedicalLeave\NewYorkFamilyMedicalLeave;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertNewYorkFamilyMedicalLeaveTax extends Migration
{
    protected $governmental_unit_areas = 'governmental_unit_areas';
    protected $tax_areas = 'tax_areas';

    /**
     * Run the migrations.
     */
    public function up()
    {
        $id = DB::table($this->governmental_unit_areas)->where('name', 'New York')->first()->id;

        DB::table($this->tax_areas)->insert([[
            'name' => 'New York Family Medical Leave Tax',
            'tax' => NewYorkFamilyMedicalLeave::class,
            'governmental_unit_area_id' => $id,
            'based' => TaxArea::BASED_ON_WORK_LOCATION,
        ]]);
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::table($this->tax_areas)->where('name', 'New York Family Medical Leave Tax')->delete();
    }
}
