<?php

use Appleton\Taxes\Countries\US\WestVirginia\WestVirginiaIncome\WestVirginiaIncome;
use Appleton\Taxes\Countries\US\WestVirginia\WestVirginiaUnemployment\WestVirginiaUnemployment;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('west_virginia_income_tax_information', static function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('two_earner_percent')->default(false);
            $table->integer('allowances')->default(0);
            $table->integer('additional_withholding')->default(0);
            $table->boolean('exempt')->default(false);
        });

        $income_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'West Virginia Income Tax',
            'class' => WestVirginiaIncome::class,
        ]);

        $unemployment_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'West Virginia Unemployment Tax',
            'class' => WestVirginiaUnemployment::class,
        ]);

        $id = DB::table('governmental_unit_areas')->where('name', 'West Virginia')->first()->id;
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
