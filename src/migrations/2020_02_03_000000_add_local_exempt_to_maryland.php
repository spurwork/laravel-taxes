<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('maryland_income_tax_information', function (Blueprint $table) {
            $table->boolean('local_exempt')->default(false);
        });
    }
};
