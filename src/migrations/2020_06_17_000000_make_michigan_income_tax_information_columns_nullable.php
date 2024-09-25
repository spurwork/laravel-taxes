<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Make state tax columns nullable
     * @return void
     */
    public function up()
    {
        Schema::table('michigan_income_tax_information', function (Blueprint $table) {
            $table->string('additional_withholding')->nullable()->change();
            $table->string('dependents')->nullable()->change();
            $table->string('filing_status')->nullable()->change();
            $table->string('exempt')->nullable()->change();
        });
    }
};
