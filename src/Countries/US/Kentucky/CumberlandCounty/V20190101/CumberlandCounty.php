<?php
namespace Appleton\Taxes\Countries\US\Kentucky\CumberlandCounty\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\CumberlandCounty\CumberlandCounty as BaseCumberlandCounty;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

class CumberlandCounty extends BaseCumberlandCounty
{
    use HasWageBase;

    public const TAX_RATE = 0.0125;
    const WAGE_BASE = 60000;

    public function compute(Collection $tax_areas)
    {
        return round($this->getAdjustedEarnings() * self::TAX_RATE, 2);
    }

    public function getAdjustedEarnings()
    {
        return min($this->payroll->getEarnings(), $this->getBaseEarnings());
    }
}
