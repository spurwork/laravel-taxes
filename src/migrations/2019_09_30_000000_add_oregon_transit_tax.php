<?php

use Appleton\Taxes\Countries\US\Oregon\OregonTransit\OregonTransit;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        $transit_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'Oregon Transit Tax',
            'class' => OregonTransit::class,
        ]);

        $oregon_id = DB::table('governmental_unit_areas')->where('name', 'Oregon')
            ->first()->id;

        DB::table('tax_areas')->insert([
            'tax_id' => $transit_tax_id,
            'home_governmental_unit_area_id' => $oregon_id,
            'work_governmental_unit_area_id' => $oregon_id,
            'based' => TaxArea::BASED_ON_EITHER_LOCATION,
        ]);
    }

    public function down()
    {
        $tax_id = DB::table('taxes')
            ->where('class', OregonTransit::class)
            ->first()
            ->id;

        DB::table('tax_areas')->where('tax_id', $tax_id)->delete();
        DB::table('taxes')->where('id', $tax_id)->delete();
    }
};
