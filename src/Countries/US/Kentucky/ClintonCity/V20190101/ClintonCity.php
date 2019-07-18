<?php
namespace Appleton\Taxes\Countries\US\Kentucky\ClintonCity\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\ClintonCity\ClintonCity as BaseClintonCity;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

class ClintonCity extends BaseClintonCity
{
    use HasWageBase;

    public const TAX_RATE = 0.005;
    const WAGE_BASE = 40000;

    public function compute(Collection $tax_areas)
    {
        $this->tax_total = $this->payroll->withholdTax($this->getBaseEarningsWageBase() * static::TAX_RATE);
        return round($this->tax_total, 2);
    }
}
