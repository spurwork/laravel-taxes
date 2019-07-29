<?php
namespace Appleton\Taxes\Countries\US\Kentucky\NelsonCounty\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\NelsonCounty\NelsonCounty as BaseNelsonCounty;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

class NelsonCounty extends BaseNelsonCounty
{
    use HasWageBase;

    public const TAX_RATE = 0.005;
    const WAGE_BASE = 15000;

    public function compute(Collection $tax_areas)
    {
        return round($this->payroll->withholdTax(min($this->payroll->getEarnings(), $this->getBaseEarnings($tax_areas->first()->workGovernmentalUnitArea)) * self::TAX_RATE), 2);
    }
}
