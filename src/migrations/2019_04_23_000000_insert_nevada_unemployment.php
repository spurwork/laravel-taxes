<?php

use Appleton\Taxes\Countries\US\Nevada\NevadaUnemployment\NevadaUnemployment;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertNevadaUnemployment extends Migration
{
    public function up()
    {
        $unemployment_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'Nevada Unemployment Tax',
            'class' => NevadaUnemployment::class,
        ]);

        $nevada_id = DB::table('governmental_unit_areas')->where('name', 'Nevada')
            ->first()->id;

        DB::table('tax_areas')->insert([
            'tax_id' => $unemployment_tax_id,
            'home_governmental_unit_area_id' => $nevada_id,
            'based' => TaxArea::BASED_ON_HOME_LOCATION,
        ]);
    }

    public function down()
    {
        $unemployment_tax_id = DB::table('taxes')->where('class', NevadaUnemployment::class)
            ->first()->id;
        DB::table('tax_areas')->where('tax_id', $unemployment_tax_id)->delete();
        DB::table('taxes')->where('id', $unemployment_tax_id)->delete();
    }
}
