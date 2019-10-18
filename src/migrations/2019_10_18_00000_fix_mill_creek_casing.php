<?php

use Appleton\Taxes\Countries\US\Ohio\MillCreekWestUnityLSD\MillCreekWestUnityLSDTax;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class FixMillCreekCasing extends Migration
{
    public function up()
    {
        DB::table('taxes')->where('name', 'Millcreek-West Unity LSD')->update([
            'name' => 'MillCreek-West Unity LSD',
            'class' => MillCreekWestUnityLSDTax::class,
        ]);
    }
}
