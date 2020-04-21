<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParametersToMaineTaxIncomeInformation extends Migration
{
    protected $maine_income_tax_information = 'maine_income_tax_information';

    public function up()
    {
        Schema::table($this->maine_income_tax_information, function (Blueprint $table) {
            $table->integer('additional_withholding')->default(0);
        });
    }
}
