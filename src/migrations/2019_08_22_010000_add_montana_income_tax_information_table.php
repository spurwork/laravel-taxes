<?php

use Appleton\Taxes\Countries\US\Montana\MontanaIncome\MontanaIncome;
use Appleton\Taxes\Countries\US\Montana\MontanaUnemployment\MontanaUnemployment;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('montana_income_tax_information', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('allowances')->default(0);
            $table->boolean('exempt')->default(false);
        });

        $income_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'Montana Income Tax',
            'class' => MontanaIncome::class,
        ]);

        $unemployment_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'Montana Unemployment Tax',
            'class' => MontanaUnemployment::class,
        ]);

        $id = DB::table('governmental_unit_areas')->where('name', 'Montana')->first()->id;

        DB::table('tax_areas')->insert([
            'tax_id' => $income_tax_id,
            'work_governmental_unit_area_id' => $id,
            'based' => TaxArea::BASED_ON_WORK_LOCATION,
        ]);

        DB::table('tax_areas')->insert([
            'tax_id' => $unemployment_tax_id,
            'home_governmental_unit_area_id' => $id,
            'based' => TaxArea::BASED_ON_HOME_LOCATION,
        ]);
    }
};
