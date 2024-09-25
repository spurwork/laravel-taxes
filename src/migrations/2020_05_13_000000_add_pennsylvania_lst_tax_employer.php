<?php

use Appleton\Taxes\Countries\US\Pennsylvania\PennsylvaniaLSTTaxEmployer\PennsylvaniaLSTTaxEmployer;
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

        $pennsylvania_lst_employer_tax_id = DB::table($this->taxes)->insertGetId([
            'name' => 'Pennsylvania LST Tax Employer',
            'class' => PennsylvaniaLSTTaxEmployer::class,
        ]);

        DB::table($this->tax_areas)->insert([[
            'tax_id' => $pennsylvania_lst_employer_tax_id,
            'work_governmental_unit_area_id' => $pennsylvania_gua_id,
            'based' => TaxArea::BASED_ON_WORK_LOCATION,
        ]]);
    }
};
