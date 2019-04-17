<?php

use Appleton\Taxes\Countries\US\Virginia\VirginiaIncome\VirginiaIncome;
use Appleton\Taxes\Countries\US\Virginia\VirginiaUnemployment\VirginiaUnemployment;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateVirginiaIncomeTaxInformation extends Migration
{
    public function up(): void
    {
        Schema::create('virginia_income_tax_information', static function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('exemptions')->default(0);
            $table->integer('sixty_five_plus_or_blind_exemptions')->default(0);
            $table->integer('additional_withholding')->default(0);
            $table->boolean('exempt')->default(false);
        });

        $income_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'Virginia Income Tax',
            'class' => VirginiaIncome::class,
        ]);

        $unemployment_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'Virginia Unemployment Tax',
            'class' => VirginiaUnemployment::class,
        ]);

        $virginia_id = DB::table('governmental_unit_areas')->where('name', 'Virginia')
            ->first()->id;
        DB::table('tax_areas')->insert([
            'tax_id' => $income_tax_id,
            'work_governmental_unit_area_id' => $virginia_id,
            'based' => TaxArea::BASED_ON_WORK_LOCATION,
        ]);

        DB::table('tax_areas')->insert([
            'tax_id' => $unemployment_tax_id,
            'home_governmental_unit_area_id' => $virginia_id,
            'based' => TaxArea::BASED_ON_HOME_LOCATION,
        ]);
    }

    public function down(): void
    {
        $income_tax_id = DB::table('taxes')->where('class', VirginiaIncome::class)
            ->first()->id;
        $unemployment_tax_id = DB::table('taxes')->where('class', VirginiaUnemployment::class)
            ->first()->id;

        DB::table('tax_areas')->where('tax_id', $income_tax_id)->delete();
        DB::table('tax_areas')->where('tax_id', $unemployment_tax_id)->delete();

        DB::table('taxes')->where('id', $income_tax_id)->delete();
        DB::table('taxes')->where('id', $unemployment_tax_id)->delete();

        Schema::drop('virginia_income_tax_information');
    }
}
