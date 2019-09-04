<?php

use Appleton\Taxes\Countries\US\SouthDakota\SouthDakotaUnemployment\SouthDakotaUnemployment;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddSouthDakotaIncomeTaxInformationTable extends Migration
{
    public function up()
    {
        $unemployment_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'South Dakota Unemployment Tax',
            'class' => SouthDakotaUnemployment::class,
        ]);

        $south_dakota_id = DB::table('governmental_unit_areas')->where('name', 'South Dakota')
            ->first()->id;

        DB::table('tax_areas')->insert([
            'tax_id' => $unemployment_tax_id,
            'home_governmental_unit_area_id' => $south_dakota_id,
            'based' => TaxArea::BASED_ON_HOME_LOCATION,
        ]);
    }

    public function down()
    {
        $unemployment_tax_id = DB::table('taxes')->where('class', SouthDakotaUnemployment::class)
            ->first()->id;
        DB::table('tax_areas')->where('tax_id', $unemployment_tax_id)->delete();
        DB::table('taxes')->where('id', $unemployment_tax_id)->delete();
    }
}
