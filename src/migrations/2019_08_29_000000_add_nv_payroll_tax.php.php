<?php

use Appleton\Taxes\Countries\US\Nevada\NevadaGrossPayrollEmployer\NevadaGrossPayrollEmployer;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $tax_id = DB::table('taxes')->insertGetId([
            'name' => 'Nevada Gross Payroll Tax',
            'class' => NevadaGrossPayrollEmployer::class,
        ]);

        $nv_id = DB::table('governmental_unit_areas')->where('name', 'Nevada')->first()->id;
        DB::table('tax_areas')->insert([[
            'tax_id' => $tax_id,
            'work_governmental_unit_area_id' => $nv_id,
            'based' => TaxArea::BASED_ON_WORK_LOCATION,
        ]]);
    }

    public function down(): void
    {
        $tax_id = DB::table('taxes')->where('class', NevadaGrossPayrollEmployer::class);

        DB::table('tax_areas')->where('tax_id', $tax_id)->delete();
        DB::table('taxes')->where('id', $tax_id)->delete();
    }
};
