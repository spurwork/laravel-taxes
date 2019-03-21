<?php

use Appleton\Taxes\Countries\US\Kentucky\KentuckyIncome\KentuckyIncome;
use Appleton\Taxes\Countries\US\Kentucky\KentuckyUnemployment\KentuckyUnemployment;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateKentuckyIncomeTaxInformation extends Migration
{
    public function up()
    {
        Schema::create('kentucky_income_tax_information', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('exemptions')->default(0);
            $table->integer('additional_withholding')->default(0);
            $table->boolean('exempt')->default(false);
        });

        $income_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'Kentucky Income Tax',
            'class' => KentuckyIncome::class,
        ]);

        $unemployment_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'Kentucky Unemployment Tax',
            'class' => KentuckyUnemployment::class,
        ]);

        $id = DB::table('governmental_unit_areas')->where('name', 'Kentucky')->first()->id;
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
}
