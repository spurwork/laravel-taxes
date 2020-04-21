<?php


namespace Appleton\Taxes\Countries\US\WestVirginia\ParkersburgCityServiceFee;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseLocal;
use Illuminate\Database\Eloquent\Collection;

abstract class ParkersburgCityServiceFee extends BaseLocal
{
    const WITHHELD = true;

    public function doesApply(Collection $tax_areas): bool
    {
        dd($this->payroll->getWtdTaxableWages(ParkersburgCityServiceFee::class));
        return $this->payroll->getEarnings($tax_areas->first()->workGovernmentalUnitArea) > 0
            &&  $this->payroll->getWtdTaxableWages(ParkersburgCityServiceFee::class) === 0.0;
    }
}
