<?php

use Appleton\Taxes\Countries\US\Pennsylvania\PennsylvaniaLocalEITTax\PennsylvaniaLocalEITTax;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    protected $governmental_unit_areas = 'governmental_unit_areas';
    protected $taxes = 'taxes';
    protected $tax_areas = 'tax_areas';

    public function up()
    {
        $pennsylvania_gua_id = DB::table($this->governmental_unit_areas)
            ->where('name', 'Pennsylvania')
            ->first()
            ->id;

        $pennsylvania_local_eid_tax_id = DB::table($this->taxes)->insertGetId([
            'name' => 'Pennsylvania Local EIT Tax',
            'class' => PennsylvaniaLocalEITTax::class,
        ]);

        DB::table($this->tax_areas)->insert([[
            'tax_id' => $pennsylvania_local_eid_tax_id,
            'work_governmental_unit_area_id' => $pennsylvania_gua_id,
            'based' => TaxArea::BASED_ON_WORK_LOCATION,
        ]]);
    }
};
