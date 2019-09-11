<?php
 use Appleton\Taxes\Countries\US\Oregon\OregonIncome\OregonIncome;
use Appleton\Taxes\Countries\US\Oregon\OregonUnemployment\OregonUnemployment;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddOregonIncomeTaxInformationTable extends Migration
{
    public function up()
    {
        Schema::create('oregon_income_tax_information', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exemptions')->default(0);
            $table->string('filing_status')->nullable();
            $table->string('additional_withholding')->default(0);
            $table->boolean('exempt')->default(false);
        });

        $income_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'Oregon Income Tax',
            'class' => OregonIncome::class,
        ]);

        $unemployment_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'Oregon Unemployment Tax',
            'class' => OregonUnemployment::class,
        ]);

        $id = DB::table('governmental_unit_areas')->where('name', 'Oregon')->first()->id;
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
