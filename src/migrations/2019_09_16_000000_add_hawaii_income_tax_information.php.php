<?php

use Appleton\Taxes\Countries\US\Hawaii\HawaiiIncome\HawaiiIncome;
use Appleton\Taxes\Countries\US\Hawaii\HawaiiUnemployment\HawaiiUnemployment;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hawaii_income_tax_information', static function (Blueprint $table) {
            $table->increments('id');
            $table->string('filing_status')->nullable();
            $table->integer('exemptions')->default(0);
            $table->integer('additional_withholding')->default(0);
            $table->boolean('exempt')->default(false);
        });

        $income_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'Hawaii Income Tax',
            'class' => HawaiiIncome::class,
        ]);

        $unemployment_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'Hawaii Unemployment Tax',
            'class' => HawaiiUnemployment::class,
        ]);

        $id = DB::table('governmental_unit_areas')->where('name', 'Hawaii')->first()->id;

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
        $tax_id = DB::table('taxes')->where('class', HawaiiIncome::class)->id;
        $unemployment_id = DB::table('taxes')->where('class', HawaiiUnemployment::class)->id;

        DB::table('tax_areas')->where('tax_id', $unemployment_id)->delete();
        DB::table('tax_areas')->where('tax_id', $tax_id)->delete();

        DB::table('taxes')->where('id', $unemployment_id)->delete();
        DB::table('taxes')->where('id', $tax_id)->delete();

        Schema::drop('hawaii_income_tax_information');
    }
};
