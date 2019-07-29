<?php
 use Appleton\Taxes\Countries\US\Pennsylvania\PennsylvaniaIncome\PennsylvaniaIncome;
use Appleton\Taxes\Countries\US\Pennsylvania\PennsylvaniaUnemployment\PennsylvaniaUnemployment;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddPennsylvaniaIncomeTaxInformationTable extends Migration
{
    public function up()
    {
        Schema::create('pennsylvania_income_tax_information', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('exempt')->default(false);
        });

        $income_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'Pennsylvania Income Tax',
            'class' => PennsylvaniaIncome::class,
        ]);

        $unemployment_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'Pennsylvania Unemployment Tax',
            'class' => PennsylvaniaUnemployment::class,
        ]);

        $id = DB::table('governmental_unit_areas')->where('name', 'Pennsylvania')->first()->id;
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
