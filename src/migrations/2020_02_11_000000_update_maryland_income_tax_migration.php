<?php

use Illuminate\Database\Migrations\Migration;

class UpdateMarylandIncomeTaxMigration extends Migration
{
    public function up()
    {
        DB::table('taxes')
            ->where('class', 'like', 'Appleton\\\\Taxes\\\\Countries\\\\US\\\\Maryland\\\\MarylandIncome\\\\%')
            ->orderBy('id')
            ->each(static function ($tax) {
                DB::table('taxes')->where('id', $tax->id)->update(['name' => 'Maryland Income Tax']);
            });

        DB::table('taxes')
            ->where('class', 'like', 'Appleton\\\\Taxes\\\\Countries\\\\US\\\\Maryland\\\\MarylandUnemployment\\\\%')
            ->orderBy('id')
            ->each(static function ($tax) {
                DB::table('taxes')->where('id', $tax->id)->update(['name' => 'Maryland Unemployment Tax']);
            });
    }
}
