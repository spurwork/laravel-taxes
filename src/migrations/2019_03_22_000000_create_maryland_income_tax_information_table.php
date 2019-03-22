<?php

use Appleton\Taxes\Countries\US\Maryland\MarylandIncome\MarylandIncome;
use Appleton\Taxes\Countries\US\Maryland\MarylandUnemployment\MarylandUnemployment;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMarylandIncomeTaxInformationTable extends Migration
{
    protected $maryland_income_tax_information = 'maryland_income_tax_information';
    protected $governmental_unit_areas = 'governmental_unit_areas';
    protected $tax_areas = 'tax_areas';

    public function up()
    {
        Schema::create($this->maryland_income_tax_information, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('additional_withholding');
            $table->integer('dependents');
            $table->integer('personal_allowances');
            $table->integer('allowances');
            $table->integer('filing_status');
            $table->boolean('exempt')->default(false);
        });

        $income_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'Maryland Income Tax',
            'class' => MarylandIncome::class,
        ]);

        $unemployment_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'Maryland Unemployment Tax',
            'class' => MarylandUnemployment::class,
        ]);

        $id = DB::table($this->governmental_unit_areas)->where('name', 'Maryland')->first()->id;

        DB::table($this->tax_areas)->insert([
            'tax_id' => $income_tax_id,
            'work_governmental_unit_area_id' => $id,
            'based' => TaxArea::BASED_ON_WORK_LOCATION,
        ]);

        DB::table($this->tax_areas)->insert([
            'tax_id' => $unemployment_tax_id,
            'home_governmental_unit_area_id' => $id,
            'based' => TaxArea::BASED_ON_HOME_LOCATION,
        ]);
    }
}