<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreParametersToPennsylvaniaIncomeTaxInformation extends Migration
{
    public function up()
    {
        Schema::table('pennsylvania_income_tax_information', function (Blueprint $table) {
            $table->boolean('exempt_from_municipal_lst')->default(false);
            $table->boolean('exempt_from_school_district_lst')->default(false);
            $table->integer('wages_from_previous_employers')->nullable();
            $table->datetime('exempt_from_lst_date')->nullable();
        });
    }
}
