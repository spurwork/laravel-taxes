<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalWithholdingToMaineIncomeTaxInformation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('maine_income_tax_information', function (Blueprint $table) {
            $table->integer('additional_withholding');
        });
    }
}
