<?php

use Appleton\Taxes\Countries\US\Alaska\AlaskaUnemployment\AlaskaUnemployment;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddAlaskaIncomeTaxInformationTable extends Migration
{
    public function up()
    {
        $unemployment_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'Alaska Unemployment Tax',
            'class' => AlaskaUnemployment::class,
        ]);

        $alaska_id = DB::table('governmental_unit_areas')->where('name', 'Alaska')
            ->first()->id;

        DB::table('tax_areas')->insert([
            'tax_id' => $unemployment_tax_id,
            'home_governmental_unit_area_id' => $alaska_id,
            'based' => TaxArea::BASED_ON_HOME_LOCATION,
        ]);
    }

    public function down()
    {
        $unemployment_tax_id = DB::table('taxes')->where('class', AlaskaUnemployment::class)
            ->first()->id;
        DB::table('tax_areas')->where('tax_id', $unemployment_tax_id)->delete();
        DB::table('taxes')->where('id', $unemployment_tax_id)->delete();
    }
}
