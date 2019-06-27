<?php

use Appleton\Taxes\Countries\US\Louisiana\LouisianaIncome\LouisianaIncome;
use Appleton\Taxes\Countries\US\Louisiana\LouisianaUnemployment\LouisianaUnemployment;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddLouisianaIncomeTaxInformationTable extends Migration
{
    public function up()
    {
        Schema::create('louisiana_income_tax_information', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exemptions')->default(0);
            $table->integer('dependents')->default(0);
            $table->integer('additional_withholding')->default(0);
            $table->string('filing_status');
            $table->boolean('exempt')->default(false);
        });

        $income_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'Louisiana Income Tax',
            'class' => LouisianaIncome::class,
        ]);

        $unemployment_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'Louisiana Unemployment Tax',
            'class' => LouisianaUnemployment::class,
        ]);

        $id = DB::table('governmental_unit_areas')->where('name', 'Louisiana')->first()->id;

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
