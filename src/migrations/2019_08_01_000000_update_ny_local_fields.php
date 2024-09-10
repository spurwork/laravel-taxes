<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('new_york_income_tax_information', static function (Blueprint $table) {
            $table->renameColumn('additional_withholding', 'ny_additional_withholding');
            $table->renameColumn('exemptions', 'ny_allowances');

            $table->integer('nyc_additional_withholding')->default(0);
            $table->integer('yonkers_additional_withholding')->default(0);
            $table->integer('nyc_allowances')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('new_york_income_tax_information', static function (Blueprint $table) {
            $table->renameColumn('ny_additional_withholding', 'additional_withholding');
            $table->renameColumn('ny_allowances', 'exemptions');
            $table->dropColumn(
                'nyc_additional_withholding',
                'yonkers_additional_withholding',
                'nyc_allowances'
            );
        });
    }
};
