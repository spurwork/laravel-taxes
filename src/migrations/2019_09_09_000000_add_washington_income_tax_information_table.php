<?php

use Appleton\Taxes\Countries\US\Washington\WashingtonUnemployment\WashingtonUnemployment;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddWashingtonIncomeTaxInformationTable extends Migration
{
    public function up()
    {
        $unemployment_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'Washington Unemployment Tax',
            'class' => WashingtonUnemployment::class,
        ]);

        $washington_id = DB::table('governmental_unit_areas')->where('name', 'Washington')
            ->first()->id;

        DB::table('tax_areas')->insert([
            'tax_id' => $unemployment_tax_id,
            'home_governmental_unit_area_id' => $washington_id,
            'based' => TaxArea::BASED_ON_HOME_LOCATION,
        ]);
    }

    public function down()
    {
        $unemployment_tax_id = DB::table('taxes')->where('class', WashingtonUnemployment::class)->first()->id;
        DB::table('tax_areas')->where('tax_id', $unemployment_tax_id)->delete();
        DB::table('taxes')->where('id', $unemployment_tax_id)->delete();
    }
}
