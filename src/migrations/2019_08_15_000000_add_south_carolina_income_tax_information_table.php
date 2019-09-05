<?php
 use Appleton\Taxes\Countries\US\SouthCarolina\SouthCarolinaIncome\SouthCarolinaIncome;
use Appleton\Taxes\Countries\US\SouthCarolina\SouthCarolinaUnemployment\SouthCarolinaUnemployment;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddSouthCarolinaIncomeTaxInformationTable extends Migration
{
    public function up()
    {
        Schema::create('south_carolina_income_tax_information', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exemptions')->default(0);
            $table->boolean('exempt')->default(false);
        });

        $income_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'South Carolina Income Tax',
            'class' => SouthCarolinaIncome::class,
        ]);

        $unemployment_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'South Carolina Unemployment Tax',
            'class' => SouthCarolinaUnemployment::class,
        ]);

        $id = DB::table('governmental_unit_areas')->where('name', 'South Carolina')->first()->id;

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
