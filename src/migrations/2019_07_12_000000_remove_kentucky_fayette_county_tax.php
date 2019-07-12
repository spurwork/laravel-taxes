<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class RemoveKentuckyFayetteCountyTax extends Migration
{
    public function up()
    {
        DB::table('taxes')->where('name', 'Fayette County Kentucky Tax')->delete();
    }
}
