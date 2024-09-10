<?php

use Appleton\Taxes\Countries\US\Delaware\DelawareTrainingTaxEmployer\DelawareTrainingTaxEmployer;
use Appleton\Taxes\Countries\US\Massachusetts\MassachusettsWorkforceTrainingFundEmployer\MassachusettsWorkforceTrainingFundEmployer;
use Appleton\Taxes\Countries\US\NewYork\NewYorkMetropolitanCommuterTransportationMobilityEmployer\NewYorkMetropolitanCommuterTransportationMobilityEmployer;
use Appleton\Taxes\Countries\US\Oregon\TransitDistrictTaxes\LaneCountyEmployer\LaneCountyEmployer;
use Appleton\Taxes\Countries\US\Oregon\TransitDistrictTaxes\SouthClackamasEmployer\SouthClackamasEmployer;
use Appleton\Taxes\Countries\US\Oregon\TransitDistrictTaxes\TriMetEmployer\TriMetEmployer;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    protected $taxes = 'taxes';

    public function up()
    {
        DB::table($this->taxes)
        ->where('name', 'Lane County Mass Oregon Transit District Tax')
        ->update([
            'name' => 'Lane County Mass Oregon Transit Employer District Tax',
            'class' => LaneCountyEmployer::class,
        ]);

        DB::table($this->taxes)
        ->where('name', 'South Clackamas Oregon Transportation District Tax')
        ->update([
            'name' => 'South Clackamas Oregon Transportation Employer District Tax',
            'class' => SouthClackamasEmployer::class,
        ]);

        DB::table($this->taxes)
        ->where('name', 'Tri-County Metropolitan Oregon Transportation District Tax')
        ->update([
            'name' => 'Tri-County Metropolitan Oregon Transportation Employer District Tax',
            'class' => TriMetEmployer::class,
        ]);

        DB::table($this->taxes)
        ->where('name', 'Delaware Employer Training Tax')
        ->update([
            'class' => DelawareTrainingTaxEmployer::class,
        ]);

        DB::table($this->taxes)
        ->where('name', 'New York Metropolitan Commuter Transportation Mobility Tax')
        ->update([
            'name' => 'New York Metropolitan Commuter Transportation Mobility Employer Tax',
            'class' => NewYorkMetropolitanCommuterTransportationMobilityEmployer::class,
        ]);

        DB::table($this->taxes)
        ->where('name', 'Massachusetts Workforce Training Fund Tax')
        ->update([
            'name' => 'Massachusetts Workforce Training Fund Employer Tax',
            'class' => MassachusettsWorkforceTrainingFundEmployer::class,
        ]);
    }
};
