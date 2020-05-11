<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateTaxInformationForEmployee extends Migration
{
    public function up()
    {
        Schema::table('tax_information', function ($table) {
            $table->integer('employee_id');
            $table->dropColumn('user_id');

            $table->foreign('employee_id')->references('id')
                ->on('users')->onUpdate('restrict')->onDelete('restrict');
        });
    }
}
