<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddExemptToIncomeTaxInformation extends Migration
{
    private $alabama_income_tax_information = 'alabama_income_tax_information';
    private $georgia_income_tax_information = 'georgia_income_tax_information';
    private $federal_income_tax_information = 'federal_income_tax_information';
    private $exempt_column = 'exempt';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->alabama_income_tax_information, function (Blueprint $table) {            
            $table->boolean($this->exempt_column)->default(false);
        });
        Schema::table($this->georgia_income_tax_information, function (Blueprint $table) {            
            $table->boolean($this->exempt_column)->default(false);
        });        
        Schema::table($this->federal_income_tax_information, function (Blueprint $table) {            
            $table->boolean($this->exempt_column)->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->alabama_income_tax_information, function (Blueprint $table) {            
            $table->dropColumn($this->exempt_column);
        });
        Schema::table($this->georgia_income_tax_information, function (Blueprint $table) {            
            $table->dropColumn($this->exempt_column);
        });
        Schema::table($this->federal_income_tax_information, function (Blueprint $table) {            
            $table->dropColumn($this->exempt_column);
        });        
    }
}
