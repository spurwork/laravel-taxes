<?php

namespace Appleton\Taxes\Countries\US\WestVirginia\ParkersburgCityServiceFee;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseLocal;
use Illuminate\Database\Eloquent\Collection;

abstract class ParkersburgCityServiceFee extends BaseLocal
{
    public const WITHHELD = true;

    public function doesApply(Collection $tax_areas): bool
    {
        dump($this->payroll->getWtdTaxableWages(ParkersburgCityServiceFee::class));
        return $this->payroll->getWtdTaxableWages(ParkersburgCityServiceFee::class) === 0.0;
    }
}
