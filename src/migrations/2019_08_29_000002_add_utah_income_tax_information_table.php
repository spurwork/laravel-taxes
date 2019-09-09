<?php
 use Appleton\Taxes\Countries\US\Utah\UtahIncome\UtahIncome;
use Appleton\Taxes\Countries\US\Utah\UtahUnemployment\UtahUnemployment;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddUtahIncomeTaxInformationTable extends Migration
{
    public function up()
    {
        Schema::create('utah_income_tax_information', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('additional_withholding')->default(0);
            $table->string('filing_status')->nullable();
            $table->boolean('exempt')->default(false);
        });

        $income_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'Utah Income Tax',
            'class' => UtahIncome::class,
        ]);

        $unemployment_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'Utah Unemployment Tax',
            'class' => UtahUnemployment::class,
        ]);

        $id = DB::table('governmental_unit_areas')->where('name', 'Utah')->first()->id;

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
        $tax_id = DB::table('taxes')->where('class', UtahIncome::class)->id;
        $unemployment_id = DB::table('taxes')->where('class', UtahUnemployment::class)->id;

        DB::table('tax_areas')->where('tax_id', $unemployment_id)->delete();
        DB::table('tax_areas')->where('tax_id', $tax_id)->delete();

        DB::table('taxes')->where('id', $unemployment_id)->delete();
        DB::table('taxes')->where('id', $tax_id)->delete();

        Schema::drop('utah_income_tax_information');
    }
}
