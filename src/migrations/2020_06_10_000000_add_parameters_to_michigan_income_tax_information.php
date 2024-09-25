<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('michigan_income_tax_information', function (Blueprint $table) {
            $table->string('resident_city')->default('');
            $table->string('primary_nonresident_city')->default('');
            $table->string('secondary_nonresident_city')->default('');
            $table->integer('primary_nonresident_city_percentage_worked')->default(0);
            $table->integer('secondary_nonresident_city_percentage_worked')->default(0);
            $table->integer('resident_exemptions')->default(0);
            $table->integer('nonresident_exemptions')->default(0);
        });
    }
};
