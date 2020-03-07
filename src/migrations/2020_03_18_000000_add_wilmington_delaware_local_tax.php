<?php

use Appleton\Taxes\Countries\US\Delaware\Wilmington\WilmingtonIncome;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddWilmingtonDelawareLocalTax extends Migration
{
    protected $governmental_unit_areas = 'governmental_unit_areas';
    protected $taxes = 'taxes';
    protected $tax_areas = 'tax_areas';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $wilmington_gua_id = DB::table($this->governmental_unit_areas)
            ->where('name', 'Wilmington, DE')
            ->first()
            ->id;


        $wilmington_tax_id = DB::table($this->taxes)->insertGetId([
            'name' => 'Wilmington Earned Income Tax',
            'class' => WilmingtonIncome::class,
        ]);

        DB::table($this->tax_areas)->insert([[
            'tax_id' => $wilmington_tax_id,
            'home_governmental_unit_area_id' => $wilmington_gua_id,
            'work_governmental_unit_area_id' => $wilmington_gua_id,
            'based' => TaxArea::BASED_ON_EITHER_LOCATION,
        ]]);
    }
}
