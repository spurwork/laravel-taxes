<?php

use Appleton\Taxes\Countries\US\Delaware\DelawareEmployerTrainingTax\DelawareEmployerTrainingTax;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        $employer_training_tax = DB::table('taxes')->insertGetId([
            'name' => 'Delaware Employer Training Tax',
            'class' => DelawareEmployerTrainingTax::class,
        ]);

        $delaware_id = DB::table('governmental_unit_areas')->where('name', 'Delaware')
            ->first()->id;

        DB::table('tax_areas')->insert([
            'tax_id' => $employer_training_tax,
            'home_governmental_unit_area_id' => $delaware_id,
            'work_governmental_unit_area_id' => $delaware_id,
            'based' => TaxArea::BASED_ON_EITHER_LOCATION,
        ]);
    }
};
