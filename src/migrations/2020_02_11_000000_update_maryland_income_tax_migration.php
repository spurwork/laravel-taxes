<?php

use Illuminate\Database\Migrations\Migration;

class UpdateMarylandIncomeTaxMigration extends Migration
{
    public function up()
    {
        DB::table('taxes')
            ->where('class', '=', MarylandIncome::class)
            ->update(['name' => 'Maryland Income Tax']);

        DB::table('taxes')
            ->where('class', '=', MarylandUnemployment::class)
            ->update(['name' => 'Maryland Unemployment Tax']);
    }
}
