<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    protected $alabama_income_tax_information = 'alabama_income_tax_information';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->alabama_income_tax_information, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('additional_withholding');
            $table->integer('dependents');
            $table->integer('filing_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop($this->alabama_income_tax_information);
    }
};
