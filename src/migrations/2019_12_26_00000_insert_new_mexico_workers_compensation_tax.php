<?php

use Appleton\Taxes\Countries\US\NewMexico\NewMexicoWorkersCompensation\NewMexicoWorkersCompensation;
use Appleton\Taxes\Countries\US\NewMexico\NewMexicoWorkersCompensationEmployer\NewMexicoWorkersCompensationEmployer;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    protected $governmental_unit_areas = 'governmental_unit_areas';
    protected $tax_areas = 'tax_areas';

    /**
     * Run the migrations.
     */
    public function up()
    {
        $id = DB::table($this->governmental_unit_areas)->where('name', 'New Mexico')->first()->id;

        $nmwc_tax = DB::table('taxes')->insertGetId([
            'name' => 'New Mexico Workers Compensation Tax',
            'class' => NewMexicoWorkersCompensation::class,
        ]);

        $nmwce_tax = DB::table('taxes')->insertGetId([
            'name' => 'New Mexico Workers Compensation Employer Tax',
            'class' => NewMexicoWorkersCompensationEmployer::class,
        ]);

        DB::table($this->tax_areas)->insert([[
            'tax_id' => $nmwc_tax,
            'work_governmental_unit_area_id' => $id,
            'based' => TaxArea::BASED_ON_WORK_LOCATION,
        ]]);

        DB::table($this->tax_areas)->insert([[
            'tax_id' => $nmwce_tax,
            'work_governmental_unit_area_id' => $id,
            'based' => TaxArea::BASED_ON_WORK_LOCATION,
        ]]);
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $tax_id = DB::table('taxes')
            ->where('class', NewMexicoWorkersCompensation::class)
            ->first()
            ->id;

        DB::table('taxes')->where('id', $tax_id)->delete();

        $employer_tax_id = DB::table('taxes')
            ->where('class', NewMexicoWorkersCompensationEmployer::class)
            ->first()
            ->id;

        DB::table('taxes')->where('id', $employer_tax_id)->delete();

        DB::table($this->tax_areas)->where('name', 'New Mexico Workers Compensation Tax')->delete();
        DB::table($this->tax_areas)->where('name', 'New Mexico Workers Compensation Employer Tax')->delete();
    }
};
