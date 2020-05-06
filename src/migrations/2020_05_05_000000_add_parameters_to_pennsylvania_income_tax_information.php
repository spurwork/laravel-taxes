<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParametersToPennsylvaniaIncomeTaxInformation extends Migration
{
    public function up()
    {
        Schema::table('pennsylvania_income_tax_information', function (Blueprint $table) {
            $table->float('non_resident_eit')->nullable();
            $table->float('resident_eit')->nullable();
        });
    }
}
