<?php

use Appleton\Taxes\Countries\US\Oregon\TransitDistrictTaxes\LaneCounty\LaneCounty;
use Appleton\Taxes\Countries\US\Oregon\TransitDistrictTaxes\SouthClackamas\SouthClackamas;
use Appleton\Taxes\Countries\US\Oregon\TransitDistrictTaxes\TriMet\TriMet;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    protected $taxes = 'taxes';

    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::table($this->taxes)->insert([
            'name' => 'Lane County Mass Oregon Transit District Tax',
            'class' => LaneCounty::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'South Clackamas Oregon Transportation District Tax',
            'class' => SouthClackamas::class,
        ]);

        DB::table($this->taxes)->insert([
            'name' => 'Tri-County Metropolitan Oregon Transportation District Tax',
            'class' => TriMet::class,
        ]);
    }
};
