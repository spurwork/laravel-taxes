<?php

use \Appleton\Taxes\Countries\US\Delaware\WilmingtonEmployerLicenseFee\WilmingtonEmployerLicenseFee;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    protected $governmental_unit_areas = 'governmental_unit_areas';

    public function up()
    {
        $employer_training_tax = DB::table('taxes')->insertGetId([
            'name' => 'Delaware Wilmington Employer License Fee',
            'class' => WilmingtonEmployerLicenseFee::class,
        ]);

        $wilmington_gua_id = DB::table($this->governmental_unit_areas)
            ->where('name', 'Wilmington, DE')
            ->first()
            ->id;

        DB::table('tax_areas')->insert([
            'tax_id' => $employer_training_tax,
            'work_governmental_unit_area_id' => $wilmington_gua_id,
            'based' => TaxArea::BASED_ON_WORK_LOCATION,
        ]);
    }
};
