<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('arkansas_income_tax_information', function (Blueprint $table) {
            $table->boolean('low_income')->default(false);
        });
    }
};
