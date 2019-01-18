<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateFederalIncomeTaxInformationTable extends Migration
{
    protected $federal_income_tax_information = 'federal_income_tax_information';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->federal_income_tax_information, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('additional_withholding');
            $table->integer('exemptions');
            $table->integer('filing_status');
            $table->boolean('non_resident_alien');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop($this->federal_income_tax_information);
    }
}
