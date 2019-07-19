<?php
namespace Appleton\Taxes\Countries\US\Kentucky\CrestviewHillsCity\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\CrestviewHillsCity\CrestviewHillsCity as BaseCrestviewHillsCity;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

class CrestviewHillsCity extends BaseCrestviewHillsCity
{
    use HasWageBase;

    public const TAX_RATE = 0.0115;
    const WAGE_BASE = 132900;

    public function compute(Collection $tax_areas)
    {
        return round($this->getAdjustedEarnings() * self::TAX_RATE, 2);
    }

    public function getAdjustedEarnings()
    {
        return min($this->payroll->getEarnings(), $this->getBaseEarnings());
    }
}
