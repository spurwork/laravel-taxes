<?php

use \Appleton\Taxes\Countries\US\NewJersey\NewJerseyDisabilityInsurance\NewJerseyDisabilityInsuranceEmployer;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertNewJerseyDisabilityInsurance extends Migration
{
    public function up()
    {
        $disability_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'New Jersey Disability Insurance Tax',
            'class' => NewJerseyDisabilityInsuranceEmployer::class,
        ]);

        $new_jersey_id = DB::table('governmental_unit_areas')->where('name', 'New Jersey')
            ->first()->id;

        DB::table('tax_areas')->insert([
            'tax_id' => $disability_tax_id,
            'work_governmental_unit_area_id' => $new_jersey_id,
            'based' => TaxArea::BASED_ON_WORK_LOCATION,
        ]);
    }

    public function down()
    {
        $tax_id = DB::table('taxes')
            ->where('class', NewJerseyDisabilityInsuranceEmployer::class)
            ->first()
            ->id;

        DB::table('tax_areas')->where('tax_id', $tax_id)->delete();
        DB::table('taxes')->where('id', $tax_id)->delete();
    }
}
