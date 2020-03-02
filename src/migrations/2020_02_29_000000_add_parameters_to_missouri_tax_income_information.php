<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParametersToMissouriTaxIncomeInformation extends Migration
{
    protected $missouri_income_tax_information = 'missouri_income_tax_information';

    public function up()
    {
        Schema::table($this->missouri_income_tax_information, function (Blueprint $table) {
            $table->boolean('use_reduced_withholding')->default(false);
            $table->integer('reduced_withholding')->nullable();
        });
    }
}
