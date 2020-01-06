<?php

use Appleton\Taxes\Countries\US\Oregon\WorkersCompAssessmentFundEmployer\WorkersCompAssessmentFundEmployer;
use Appleton\Taxes\Countries\US\Oregon\WorkersCompAssessmentFund\WorkersCompAssessmentFund;
use Appleton\Taxes\Models\TaxArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddWorkersCompAssessmentFunds extends Migration
{
    protected $governmental_unit_areas = 'governmental_unit_areas';
    protected $taxes = 'taxes';
    protected $tax_areas = 'tax_areas';

    public function up()
    {
        $workers_comp_assessment_fund_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'Workers Compensation Assessment Fund Tax',
            'class' => WorkersCompAssessmentFund::class,
        ]);

        $oregon_id = DB::table('governmental_unit_areas')->where('name', 'Oregon')
            ->first()->id;

        DB::table('tax_areas')->insert([
            'tax_id' => $workers_comp_assessment_fund_tax_id,
            'work_governmental_unit_area_id' => $oregon_id,
            'based' => TaxArea::BASED_ON_WORK_LOCATION,
        ]);

        $workers_comp_assessment_fund_employer_tax_id = DB::table('taxes')->insertGetId([
            'name' => 'Workers Compensation Assessment Fund Employer Tax',
            'class' => WorkersCompAssessmentFundEmployer::class,
        ]);

        DB::table('tax_areas')->insert([
            'tax_id' => $workers_comp_assessment_fund_employer_tax_id,
            'work_governmental_unit_area_id' => $oregon_id,
            'based' => TaxArea::BASED_ON_WORK_LOCATION,
        ]);
    }
}
