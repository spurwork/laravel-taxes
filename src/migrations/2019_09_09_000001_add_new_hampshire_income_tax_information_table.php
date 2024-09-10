<?php

use Appleton\Taxes\Countries\US\NewHampshire\NewHampshireUnemployment\NewHampshireUnemployment;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        $unemployment_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'New Hampshire Unemployment Tax',
            'class' => NewHampshireUnemployment::class,
        ]);

        $new_hampshire_id = DB::table('governmental_unit_areas')->where('name', 'New Hampshire')
            ->first()->id;

        DB::table('tax_areas')->insert([
            'tax_id' => $unemployment_tax_id,
            'home_governmental_unit_area_id' => $new_hampshire_id,
            'based' => TaxArea::BASED_ON_HOME_LOCATION,
        ]);
    }

    public function down()
    {
        $unemployment_tax_id = DB::table('taxes')->where('class', NewHampshireUnemployment::class)
            ->first()->id;
        DB::table('tax_areas')->where('tax_id', $unemployment_tax_id)->delete();
        DB::table('taxes')->where('id', $unemployment_tax_id)->delete();
    }
};
