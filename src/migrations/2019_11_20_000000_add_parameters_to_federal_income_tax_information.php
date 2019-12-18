<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParametersToFederalIncomeTaxInformation extends Migration
{
    protected $federal_income_tax_information = 'federal_income_tax_information';

    public function up()
    {
        Schema::table($this->federal_income_tax_information, function (Blueprint $table) {
            $table->integer('other_income')->nullable();
            $table->integer('deductions')->nullable();
            $table->integer('dependents')->nullable();
            $table->integer('extra_withholding')->nullable();
            $table->boolean('step_2_checked')->nullable();
            $table->string('form_version')->default('2020')->nullable();
        });

        DB::table($this->federal_income_tax_information)
            ->whereNull('form_version')
            ->update([
                'form_version' => '2019',
        ]);

        Schema::table($this->federal_income_tax_information, function (Blueprint $table) {
            $table->string('form_version')->nullable(false)->change();
        });
    }
}
