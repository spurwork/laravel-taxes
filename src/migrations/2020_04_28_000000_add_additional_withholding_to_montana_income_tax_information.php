<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('montana_income_tax_information', function (Blueprint $table) {
            $table->integer('additional_withholding')->default(0);
        });
    }
};
