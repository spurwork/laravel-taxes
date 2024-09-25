<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('indiana_income_tax_information', function (Blueprint $table) {
            $table->integer('county_worked');
            $table->integer('county_lived');
        });
    }

    public function down()
    {
        Schema::table('indiana_income_tax_information', function (Blueprint $table) {
            $table->dropColumn('county_worked');
            $table->dropColumn('county_lived');
        });
    }
};