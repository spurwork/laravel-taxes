<?php

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTax\OhioSchoolDistrictTax;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddOhioSchoolDistrictTax extends Migration
{
    protected $governmental_unit_areas = 'governmental_unit_areas';
    protected $taxes = 'taxes';
    protected $tax_areas = 'tax_areas';

    /**
     * Run the migrations.
     */
    public function up()
    {
        $ohio_gua_id = DB::table($this->governmental_unit_areas)
            ->where('name', 'Ohio')
            ->first()
            ->id;

        $ohio_disability_id = DB::table($this->taxes)->insertGetId([
            'name' => 'Ohio School District Tax',
            'class' => OhioSchoolDistrictTax::class,
        ]);

        DB::table($this->tax_areas)->insert([
            'tax_id' => $ohio_disability_id,
            'work_governmental_unit_area_id' => $ohio_gua_id,
            'based' => TaxArea::BASED_ON_WORK_LOCATION,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $ohio_school_district_tax_id = DB::table($this->taxes)
            ->where('name', 'Ohio School District Tax')
            ->first()
            ->id;

        DB::table($this->taxes)->where('id', $ohio_school_district_tax_id)->delete();

        $ohio_gua_id = DB::table($this->governmental_unit_areas)
            ->where('name', 'Ohio')
            ->first()
            ->id;

        DB::table($this->governmental_unit_areas)->where('id', $ohio_gua_id)->delete();
        DB::table($this->tax_areas)->where('tax_id', $ohio_school_district_tax_id)->delete();
    }
}
