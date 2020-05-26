<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class UpdateColumnsInNorthDakotaIncomeTaxInformation
 * Update the North Dakota income tax information table to include W4 clone columns.
 */
class UpdateColumnsInNorthDakotaIncomeTaxInformation extends Migration
{
    protected $north_dakota_income_tax_information = 'north_dakota_income_tax_information';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->north_dakota_income_tax_information, function (Blueprint $table) {
            $table->dropColumn('exemptions');
            $table->dropColumn('filing_status');
        });
        Schema::table($this->north_dakota_income_tax_information, function (Blueprint $table) {
            $table->integer('deductions')->nullable();
            $table->integer('dependents_deduction_amount')->nullable();
            $table->integer('extra_withholding')->nullable();
            $table->integer('filing_status')->nullable();
            $table->integer('other_income')->nullable();
            $table->boolean('step_2_checked')->default(false);
        });
    }
}
