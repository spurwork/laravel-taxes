<?php

use Appleton\Taxes\Countries\US\California\CaliforniaDisabilityInsurance\CaliforniaDisabilityInsurance;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddCaliforniaDisabilityInsurance extends Migration
{
    protected $governmental_unit_areas = 'governmental_unit_areas';
    protected $taxes = 'taxes';
    protected $tax_areas = 'tax_areas';

    /**
    * Run the migrations.
    */
    public function up()
    {
        $california_gua_id = DB::table($this->governmental_unit_areas)
            ->where('name', 'California')
            ->first()
            ->id;

        $california_disability_id = DB::table($this->taxes)->insertGetId([
            'name' => 'California Disability Insurance',
            'class' => CaliforniaDisabilityInsurance::class,
        ]);

        DB::table($this->tax_areas)->insert([
            'tax_id' => $california_disability_id,
            'work_governmental_unit_area_id' => $california_gua_id,
            'based' => TaxArea::BASED_ON_WORK_LOCATION,
        ]);
    }

    /**
    * Reverse the migrations.
    */
    public function down()
    {
        $california_di_tax_id = DB::table($this->taxes)
            ->where('name', 'California Disability Insurance')
            ->first()
            ->id;

        DB::table($this->taxes)->where('id', $california_di_tax_id)->delete();

        $california_gua_id = DB::table($this->governmental_unit_areas)
            ->where('name', 'California')
            ->first()
            ->id;

        DB::table($this->governmental_unit_areas)->where('id', $california_gua_id)->delete();
        DB::table($this->tax_areas)->where('tax_id', $california_di_tax_id)->delete();
    }
}
