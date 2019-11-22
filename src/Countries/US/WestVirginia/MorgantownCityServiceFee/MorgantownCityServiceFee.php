<?php


namespace Appleton\Taxes\Countries\US\WestVirginia\MorgantownCityServiceFee;


use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseLocal;
use Illuminate\Database\Eloquent\Collection;

abstract class MorgantownCityServiceFee extends BaseLocal
{
    const WITHHELD = true;

    public function doesApply(Collection $tax_areas): bool
    {
        return $this->payroll->getEarnings($tax_areas->first()->workGovernmentalUnitArea) > 0;
    }
}
