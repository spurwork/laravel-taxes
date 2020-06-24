<?php

namespace Appleton\Taxes\Countries\US\WestVirginia\FairmontCityServiceFee;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseLocal;
use Illuminate\Database\Eloquent\Collection;

abstract class FairmontCityServiceFee extends BaseLocal
{
    const WITHHELD = true;

    public function doesApply(Collection $tax_areas): bool
    {
        return $this->payroll->getWtdEarnings($tax_areas->first()->workGovernmentalUnitArea) === 0.0;
    }
}
