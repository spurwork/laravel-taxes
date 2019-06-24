<?php

use Appleton\Taxes\Countries\US\NewJersey\NewJerseyFamilyMedicalLeave\NewJerseyFamilyMedicalLeave;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertNewJerseyFamilyMedicalLeave extends Migration
{
    protected $governmental_unit_areas = 'governmental_unit_areas';
    protected $taxes = 'taxes';
    protected $tax_areas = 'tax_areas';

    /**
    * Run the migrations.
    */
    public function up()
    {
        DB::table($this->taxes)->insert([[
            'name' => 'New Jersey Family Medical Leave',
            'class' => NewJerseyFamilyMedicalLeave::class,
        ]]);

        $new_jersey_family_medical_leave_id = DB::table($this->taxes)
            ->where('name', 'New Jersey Family Medical Leave')
            ->first()
            ->id;

        $new_jersey_gua_id = DB::table($this->governmental_unit_areas)
            ->where('name', 'New Jersey')
            ->first()
            ->id;

        DB::table($this->tax_areas)->insert([[
            'tax_id' => $new_jersey_family_medical_leave_id,
            'home_governmental_unit_area_id' => $new_jersey_gua_id,
            'work_governmental_unit_area_id' => $new_jersey_gua_id,
            'based' => TaxArea::BASED_ON_WORK_LOCATION,
        ]]);
    }

    /**
    * Reverse the migrations.
    */
    public function down()
    {
        $new_jersey_tax_id = DB::table($this->taxes)
            ->where('name', 'New Jersey Family Medical Leave')
            ->first()
            ->id;

        DB::table($this->taxes)->where('id', $new_jersey_tax_id)->delete();

        $new_jersey_gua_id = DB::table($this->governmental_unit_areas)
            ->where('name', 'New Jersey')
            ->first()
            ->id;

        DB::table($this->governmental_unit_areas)->where('id', $new_jersey_gua_id)->delete();
        DB::table($this->tax_areas)->where('tax_id', $new_jersey_tax_id)->delete();
    }
}
