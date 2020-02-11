<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParametersToUtahIncomeTaxInformation extends Migration
{
    protected $utah_income_tax_information = 'utah_income_tax_information';

    public function up()
    {
        Schema::table($this->utah_income_tax_information, function (Blueprint $table) {
            $table->integer('other_income')->nullable();
            $table->integer('deductions')->nullable();
            $table->integer('dependents_deduction_amount')->nullable();
            $table->integer('extra_withholding')->nullable();
            $table->boolean('step_2_checked')->nullable();
        });

        Schema::table($this->utah_income_tax_information, function (Blueprint $table) {
            $table->dropColumn('filing_status');
        });

        Schema::table($this->utah_income_tax_information, function (Blueprint $table) {
            $table->integer('filing_status')->default(0);
        });
    }
}
