<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalWithholdingToOhio extends Migration
{
    public function up()
    {
        Schema::table('ohio_income_tax_information', function (Blueprint $table) {
            $table->string('additional_withholding')->default(0);
        });
    }
}
