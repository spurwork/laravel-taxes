<?php

namespace Appleton\Taxes\Countries\US\California\SacrementoBusinessOperationsTax\V20190101;

use Appleton\Taxes\Countries\US\California\SacrementoBusinessOperationsTax\SacrementoBusinessOperationsTax as BaseSacrementoBusinessOperationsTax;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

class SacrementoBusinessOperationsTax extends BaseSacrementoBusinessOperationsTax
{
    // use HasWageBase;

    // const TAX_RATE = 0.001;
    // const WAGE_BASE = 7000;

    // public function compute(Collection $tax_areas)
    // {
    //     return round($this->payroll->withholdTax(min($this->payroll->getEarnings(), $this->getBaseEarnings($tax_areas->first()->workGovernmentalUnitArea)) * self::TAX_RATE), 2);
    // }
}
