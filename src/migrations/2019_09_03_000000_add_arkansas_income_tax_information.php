<?php

use Appleton\Taxes\Countries\US\Arkansas\ArkansasIncome\ArkansasIncome;
use Appleton\Taxes\Countries\US\Arkansas\ArkansasUnemployment\ArkansasUnemployment;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('arkansas_income_tax_information', static function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exemptions')->default(0);
            $table->integer('additional_withholding')->default(0);
            $table->boolean('exempt')->default(false);
        });

        $income_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'Arkansas Income Tax',
            'class' => ArkansasIncome::class,
        ]);

        $unemployment_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'Arkansas Unemployment Tax',
            'class' => ArkansasUnemployment::class,
        ]);

        $id = DB::table('governmental_unit_areas')->where('name', 'Arkansas')->first()->id;

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
        $tax_id = DB::table('taxes')->where('class', ArkansasIncome::class)->id;
        $unemployment_id = DB::table('taxes')->where('class', ArkansasUnemployment::class)->id;

        DB::table('tax_areas')->where('tax_id', $unemployment_id)->delete();
        DB::table('tax_areas')->where('tax_id', $tax_id)->delete();

        DB::table('taxes')->where('id', $unemployment_id)->delete();
        DB::table('taxes')->where('id', $tax_id)->delete();

        Schema::drop('arkansas_income_tax_information');
    }
};
