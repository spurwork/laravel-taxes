<?php


namespace Appleton\Taxes\Countries\US\WestVirginia\ParkersburgCityServiceFee;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseLocal;
use Illuminate\Database\Eloquent\Collection;

abstract class ParkersburgCityServiceFee extends BaseLocal
{
    const WITHHELD = true;

    public function doesApply(Collection $tax_areas): bool
    {
        dump($this->payroll->getWtdTaxableWages(ParkersburgCityServiceFee::class).' does apply, should be more than 0');
        return $this->payroll->getWtdTaxableWages(ParkersburgCityServiceFee::class) === 0.0;
    }
}
