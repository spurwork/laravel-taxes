<?php

use Appleton\Taxes\Countries\US\Washington\WashingtonFamilyMedicalLeaveEmployer\WashingtonFamilyMedicalLeaveEmployer;
use Appleton\Taxes\Countries\US\Washington\WashingtonFamilyMedicalLeave\WashingtonFamilyMedicalLeave;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertWashingtonFamilyMedicalLeaveTax extends Migration
{
    protected $governmental_unit_areas = 'governmental_unit_areas';
    protected $tax_areas = 'tax_areas';

    /**
     * Run the migrations.
     */
    public function up()
    {
        $id = DB::table($this->governmental_unit_areas)->where('name', 'Washington')->first()->id;

        $washington_fml_tax = DB::table('taxes')->insertGetId([
            'name' => 'Washington Family Medical Leave Tax',
            'class' => WashingtonFamilyMedicalLeave::class,
        ]);

        $washington_fml_employer_tax = DB::table('taxes')->insertGetId([
            'name' => 'Washington Family Medical Leave Employer Tax',
            'class' => WashingtonFamilyMedicalLeaveEmployer::class,
        ]);

        DB::table($this->tax_areas)->insert([[
            'tax_id' => $washington_fml_tax,
            'work_governmental_unit_area_id' => $id,
            'based' => TaxArea::BASED_ON_WORK_LOCATION,
        ]]);

        DB::table($this->tax_areas)->insert([[
            'tax_id' => $washington_fml_employer_tax,
            'work_governmental_unit_area_id' => $id,
            'based' => TaxArea::BASED_ON_WORK_LOCATION,
        ]]);
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $tax_id = DB::table('taxes')
            ->where('class', WashingtonFamilyMedicalLeave::class)
            ->first()
            ->id;

        DB::table('taxes')->where('id', $tax_id)->delete();

        $employer_tax_id = DB::table('taxes')
            ->where('class', WashingtonFamilyMedicalLeaveEmployer::class)
            ->first()
            ->id;

        DB::table('taxes')->where('id', $employer_tax_id)->delete();

        DB::table($this->tax_areas)->where('name', 'Washington Family Medical Leave Tax')->delete();
        DB::table($this->tax_areas)->where('name', 'Washington Family Medical Leave Employer Tax')->delete();
    }
}
