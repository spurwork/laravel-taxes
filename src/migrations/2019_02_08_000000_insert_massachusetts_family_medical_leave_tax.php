<?php

use Appleton\Taxes\Countries\US\Massachusetts\MassachusettsFamilyMedicalLeave\MassachusettsFamilyMedicalLeave;
use Appleton\Taxes\Countries\US\Massachusetts\MassachusettsFamilyMedicalLeaveEmployer\MassachusettsFamilyMedicalLeaveEmployer;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertMassachusettsFamilyMedicalLeaveTax extends Migration
{
    protected $governmental_unit_areas = 'governmental_unit_areas';
    protected $tax_areas = 'tax_areas';

    /**
     * Run the migrations.
     */
    public function up()
    {
        $id = DB::table($this->governmental_unit_areas)->where('name', 'Massachusetts')->first()->id;

        DB::table($this->tax_areas)->insert([[
            'name' => 'Massachusetts Family Medical Leave Tax',
            'tax' => MassachusettsFamilyMedicalLeave::class,
            'governmental_unit_area_id' => $id,
            'based' => TaxArea::BASED_ON_WORK_LOCATION,
        ]]);

        DB::table($this->tax_areas)->insert([[
            'name' => 'Massachusetts Family Medical Leave Employer Tax',
            'tax' => MassachusettsFamilyMedicalLeaveEmployer::class,
            'governmental_unit_area_id' => $id,
            'based' => TaxArea::BASED_ON_WORK_LOCATION,
        ]]);
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::table($this->tax_areas)->where('name', 'Massachusetts Family Medical Leave Tax')->delete();
        DB::table($this->tax_areas)->where('name', 'Massachusetts Family Medical Leave Employer Tax')->delete();
    }
}
