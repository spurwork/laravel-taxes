<?php
namespace Appleton\Taxes\Countries\US\Kentucky\NewportCity\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\NewportCity\NewportCity as BaseNewportCity;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

class NewportCity extends BaseNewportCity
{
    use HasWageBase;

    public const TAX_RATE = 0.025;
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
