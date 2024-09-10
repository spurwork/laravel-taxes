<?php

use Appleton\Taxes\Countries\US\Illinois\IllinoisIncome\IllinoisIncome;
use Appleton\Taxes\Countries\US\Illinois\IllinoisUnemployment\IllinoisUnemployment;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('illinois_income_tax_information', static function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('basic_allowances')->default(0);
            $table->decimal('additional_allowances')->default(0);
            $table->integer('additional_withholding')->default(0);
            $table->boolean('exempt')->default(false);
        });

        $income_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'Illinois Income Tax',
            'class' => IllinoisIncome::class,
        ]);

        $unemployment_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'Illinois Unemployment Tax',
            'class' => IllinoisUnemployment::class,
        ]);

        $id = DB::table('governmental_unit_areas')->where('name', 'Illinois')->first()->id;
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
        $income_tax_id = DB::table('taxes')->where('class', IllinoisIncome::class)
            ->first()->id;
        DB::table('tax_areas')->where('tax_id', $income_tax_id)->delete();

        $unemployment_tax_id = DB::table('taxes')->where('class', IllinoisUnemployment::class)
            ->first()->id;
        DB::table('tax_areas')->where('tax_id', $unemployment_tax_id)->delete();

        DB::table('taxes')->where('id', $income_tax_id)->delete();
        DB::table('taxes')->where('id', $unemployment_tax_id)->delete();

        Schema::drop('illinois_income_tax_information');
    }
};
