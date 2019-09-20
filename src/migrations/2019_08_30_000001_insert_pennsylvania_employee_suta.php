<?php

use \Appleton\Taxes\Countries\US\Pennsylvania\PennsylvaniaEmployeeSuta\PennsylvaniaEmployeeSuta;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertPennsylvaniaEmployeeSuta extends Migration
{
    public function up()
    {
        $disability_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'PA Employee SUI',
            'class' => PennsylvaniaEmployeeSuta::class,
        ]);

        $pennsylvania_id = DB::table('governmental_unit_areas')->where('name', 'Pennsylvania')
            ->first()->id;

        DB::table('tax_areas')->insert([
            'tax_id' => $disability_tax_id,
            'home_governmental_unit_area_id' => $pennsylvania_id,
            'based' => TaxArea::BASED_ON_HOME_LOCATION,
        ]);
    }

    public function down()
    {
        $tax_id = DB::table('taxes')
            ->where('class', PennsylvaniaEmployeeSuta::class)
            ->first()
            ->id;

        DB::table('tax_areas')->where('tax_id', $tax_id)->delete();
        DB::table('taxes')->where('id', $tax_id)->delete();
    }
}
