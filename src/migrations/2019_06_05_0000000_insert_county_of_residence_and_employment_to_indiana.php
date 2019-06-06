<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertCountyOfResidenceAndEmploymentToIndiana extends Migration
{
    public function up()
    {
        Schema::table('indiana_income_tax_information', function (Blueprint $table) {
            $table->string('county_of_residence')->nullable();
            $table->string('county_of_employment')->nullable();
        });
    }
}
