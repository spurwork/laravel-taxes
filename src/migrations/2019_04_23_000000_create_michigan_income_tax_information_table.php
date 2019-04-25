<?php

use Appleton\Taxes\Countries\US\Michigan\MichiganIncome\MichiganIncome;
use Appleton\Taxes\Countries\US\Michigan\MichiganUnemployment\MichiganUnemployment;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMichiganIncomeTaxInformationTable extends Migration
{
    protected $michigan_income_tax_information = 'michigan_income_tax_information';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create($this->michigan_income_tax_information, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('additional_withholding');
            $table->integer('dependents');
            $table->integer('filing_status');
            $table->boolean('exempt')->default(false);
        });

        $income_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'Michigan Income Tax',
            'class' => MichiganIncome::class,
        ]);

        $unemployment_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'Michigan Unemployment Tax',
            'class' => MichiganUnemployment::class,
        ]);

        $michigan_id = DB::table('governmental_unit_areas')->where('name', 'Michigan')
            ->first()->id;

        DB::table('tax_areas')->insert([
            'tax_id' => $income_tax_id,
            'work_governmental_unit_area_id' => $michigan_id,
            'based' => TaxArea::BASED_ON_WORK_LOCATION,
        ]);

        DB::table('tax_areas')->insert([
            'tax_id' => $unemployment_tax_id,
            'home_governmental_unit_area_id' => $michigan_id,
            'based' => TaxArea::BASED_ON_HOME_LOCATION,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop($this->michigan_income_tax_information);
    }
}
