<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    protected $colorado_income_tax_information = 'colorado_income_tax_information';

    public function up()
    {
        Schema::table($this->colorado_income_tax_information, function (Blueprint $table) {
            $table->integer('other_income')->nullable();
            $table->integer('deductions')->nullable();
            $table->integer('dependents_deduction_amount')->nullable();
            $table->integer('extra_withholding')->nullable();
            $table->boolean('step_2_checked')->nullable();
            $table->string('form_version')->nullable();
        });

        DB::table($this->colorado_income_tax_information)
            ->whereNull('form_version')
            ->update([
                'form_version' => '2019',
        ]);

        Schema::table($this->colorado_income_tax_information, function (Blueprint $table) {
            $table->string('form_version')->nullable(false)->default('2020')->change();
        });
    }
};
