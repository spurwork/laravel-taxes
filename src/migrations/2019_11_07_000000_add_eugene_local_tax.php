<?php

use Appleton\Taxes\Countries\US\Oregon\Eugene\Eugene;

use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddEugeneLocalTax extends Migration
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
        $eugene_gua_id = DB::table($this->governmental_unit_areas)
            ->where('name', 'Eugene, OR')
            ->first()
            ->id;

        $eugene_tax_id = DB::table($this->taxes)->insertGetId([
            'name' => 'Eugene Oregon Tax',
            'class' => Eugene::class,
        ]);

        DB::table($this->tax_areas)->insert([[
            'tax_id' => $eugene_tax_id,
            'work_governmental_unit_area_id' => $eugene_gua_id,
            'based' => TaxArea::BASED_ON_WORK_LOCATION,
        ]]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $eugene_tax_id = DB::table($this->taxes)
            ->where('class', Eugene::class)
            ->first()
            ->id;

        DB::table($this->tax_areas)->where('tax_id', $eugene_tax_id)->delete();
        DB::table($this->taxes)->where('id', $eugene_tax_id)->delete();
        DB::table($this->governmental_unit_areas)->where('name', 'Eugene, OR')->delete();
    }
}
