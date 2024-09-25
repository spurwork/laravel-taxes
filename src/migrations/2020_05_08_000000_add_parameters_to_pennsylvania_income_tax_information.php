<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('pennsylvania_income_tax_information', function (Blueprint $table) {
            $table->float('employer_eit_rate')->nullable();
            $table->float('resident_eit_rate')->nullable();
            $table->boolean('is_resident_psd_code_philadelphia')->default(false);
            $table->boolean('is_employer_psd_code_philadelphia')->default(false);
            $table->integer('municipal_lst_total')->nullable();
            $table->integer('school_district_lst_total')->nullable();
            $table->integer('municipal_lst_lie_total')->nullable();
            $table->integer('school_district_lst_lie_total')->nullable();
            $table->integer('lst_paid_to_previous_employers')->nullable();
        });
    }
};
