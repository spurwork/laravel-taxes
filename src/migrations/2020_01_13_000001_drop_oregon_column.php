<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropOregonColumn extends Migration
{
    public function up()
    {
        Schema::table('oregon_income_tax_information', function (Blueprint $table) {
            $table->dropColumn('additional_withholding');
        });
    }
}
