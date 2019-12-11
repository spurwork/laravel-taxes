<?php

// use Appleton\Taxes\Countries\US\Washington\WashingtonWorkersCompensationEmployer\WashingtonWorkersCompensationEmployer;
use Appleton\Taxes\Countries\US\Washington\WashingtonWorkersCompensation\WashingtonWorkersCompensation;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertWashingtonWorkersCompensationTax extends Migration
{
    protected $governmental_unit_areas = 'governmental_unit_areas';
    protected $tax_areas = 'tax_areas';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('washington_workers_compensation_tax_information', function (Blueprint $table) {
            $table->increments('id');
            $table->string('class_code')->default('');
            $table->string('subclass_code')->default('');
            $table->integer('employee_rate')->default(0);
            $table->integer('employer_rate')->default(0);
            $table->dateTime('effective_date')->nullable();
        });

        $id = DB::table($this->governmental_unit_areas)->where('name', 'Washington')->first()->id;

        $washington_wc_tax = DB::table('taxes')->insertGetId([
            'name' => 'Washington Workers Compensation Tax',
            'class' => WashingtonWorkersCompensation::class,
        ]);

        $washington_wc_employer_tax = DB::table('taxes')->insertGetId([
            'name' => 'Washington Workers Compensation Employer Tax',
            'class' => WashingtonWorkersCompensationEmployer::class,
        ]);

        DB::table($this->tax_areas)->insert([[
            'tax_id' => $washington_wc_tax,
            'work_governmental_unit_area_id' => $id,
            'based' => TaxArea::BASED_ON_WORK_LOCATION,
        ]]);

        DB::table($this->tax_areas)->insert([[
            'tax_id' => $washington_wc_employer_tax,
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
            ->where('class', WashingtonWorkersCompensation::class)
            ->first()
            ->id;

        DB::table('taxes')->where('id', $tax_id)->delete();

        $employer_tax_id = DB::table('taxes')
            ->where('class', WashingtonWorkersCompensationEmployer::class)
            ->first()
            ->id;

        DB::table('taxes')->where('id', $employer_tax_id)->delete();

        DB::table($this->tax_areas)->where('name', 'Washington Workers Compensation Tax')->delete();
        DB::table($this->tax_areas)->where('name', 'Washington Workers Compensation Employer Tax')->delete();
    }
}
