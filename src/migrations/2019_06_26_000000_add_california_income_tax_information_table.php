<?php

use Appleton\Taxes\Countries\US\California\CaliforniaIncome\CaliforniaIncome;
use Appleton\Taxes\Countries\US\California\CaliforniaUnemployment\CaliforniaUnemployment;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddCaliforniaIncomeTaxInformationTable extends Migration
{
    public function up()
    {
        Schema::create('california_income_tax_information', static function (Blueprint $table) {
            $table->increments('id');
            $table->string('filing_status')->nullable();
            $table->integer('allowances')->nullable();
            $table->integer('estimated_deductions')->default(0);
            $table->integer('additional_withholding')->default(0);
            $table->boolean('exempt')->default(false);
        });

        $income_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'California Income Tax',
            'class' => CaliforniaIncome::class,
        ]);

        $unemployment_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'California Unemployment Tax',
            'class' => CaliforniaUnemployment::class,
        ]);

        $id = DB::table('governmental_unit_areas')->where('name', 'California')->first()->id;
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

    public function down(): void
    {
        $income_tax_id = DB::table('taxes')->where('class', CaliforniaIncome::class)
            ->first()->id;
        DB::table('tax_areas')->where('tax_id', $income_tax_id)->delete();

        $unemployment_tax_id = DB::table('taxes')->where('class', CaliforniaUnemployment::class)
            ->first()->id;
        DB::table('tax_areas')->where('tax_id', $unemployment_tax_id)->delete();

        DB::table('taxes')->where('id', $income_tax_id)->delete();
        DB::table('taxes')->where('id', $unemployment_tax_id)->delete();

        Schema::drop('california_income_tax_information');
    }
}
