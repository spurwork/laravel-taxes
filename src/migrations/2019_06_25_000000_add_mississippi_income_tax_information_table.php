<?php

use Appleton\Taxes\Countries\US\Mississippi\MississippiIncome\MississippiIncome;
use Appleton\Taxes\Countries\US\Mississippi\MississippiUnemployment\MississippiUnemployment;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddMississippiIncomeTaxInformationTable extends Migration
{
    public function up()
    {
        Schema::create('mississippi_income_tax_information', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('additional_withholding')->default(0);
            $table->boolean('exempt')->default(false);
            $table->string('filing_status');
            $table->integer('exemption_amount')->default(0);
        });

        $income_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'Mississippi Income Tax',
            'class' => MississippiIncome::class,
        ]);

        $unemployment_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'Mississippi Unemployment Tax',
            'class' => MississippiUnemployment::class,
        ]);

        $id = DB::table('governmental_unit_areas')->where('name', 'Mississippi')->first()->id;
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
