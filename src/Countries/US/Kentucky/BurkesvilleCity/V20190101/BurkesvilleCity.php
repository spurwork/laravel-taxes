<?php
namespace Appleton\Taxes\Countries\US\Kentucky\BurkesvilleCity\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\BurkesvilleCity\BurkesvilleCity as BaseBurkesvilleCity;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

class BurkesvilleCity extends BaseBurkesvilleCity
{
    use HasWageBase;

    public const TAX_RATE = 0.02;
    const WAGE_BASE = 37500;

    public function compute(Collection $tax_areas)
    {
        return round($this->payroll->withholdTax(min($this->payroll->getEarnings(), $this->getBaseEarnings($tax_areas->first()->workGovernmentalUnitArea)) * self::TAX_RATE), 2);
    }
}
