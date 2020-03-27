<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParametersToMinnesotaTaxIncomeInformation extends Migration
{
    protected $minnesota_income_tax_information = 'minnesota_income_tax_information';

    public function up()
    {
        Schema::table($this->minnesota_income_tax_information, function (Blueprint $table) {
            $table->integer('additional_withholding')->default(0);
        });
    }
}
