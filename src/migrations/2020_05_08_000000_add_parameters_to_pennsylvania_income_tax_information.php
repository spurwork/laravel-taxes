<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParametersToPennsylvaniaIncomeTaxInformation extends Migration
{
    public function up()
    {
        Schema::table('pennsylvania_income_tax_information', function (Blueprint $table) {
            $table->float('employer_eit_rate')->nullable();
            $table->float('resident_eit_rate')->nullable();
            $table->string('resident_psd_code')->default('');
            $table->string('employer_psd_code')->default('');
            $table->boolean('exempt_from_lst')->default(false);
        });
    }
}
