<?php

use Appleton\Taxes\Countries\US\NewJersey\NewJerseyIncome\NewJerseyIncome;
use Appleton\Taxes\Countries\US\NewJersey\NewJerseyUnemployment\NewJerseyUnemployment;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddNewJerseyIncomeTaxInformationTable extends Migration
{
    public function up()
    {
        Schema::create('new_jersey_income_tax_information', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('exemptions')->default(0);
            $table->integer('additional_withholding')->default(0);
            $table->string('filing_status');
            $table->string('tax_rate_table')->nullable();
            $table->boolean('exempt')->default(false);
        });

        $income_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'New Jersey Income Tax',
            'class' => NewJerseyIncome::class,
        ]);

        $unemployment_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'New Jersey Unemployment Tax',
            'class' => NewJerseyUnemployment::class,
        ]);

        $id = DB::table('governmental_unit_areas')->where('name', 'New Jersey')->first()->id;

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
