<?php
namespace Appleton\Taxes\Countries\US\Kentucky\ParkHillsCity\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\ParkHillsCity\ParkHillsCity as BaseParkHillsCity;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

class ParkHillsCity extends BaseParkHillsCity
{
    use HasWageBase;

    public const TAX_RATE = 0.015;
    const WAGE_BASE = 50000;

    public function compute(Collection $tax_areas)
    {
        $this->tax_total = $this->payroll->withholdTax($this->getBaseEarningsWageBase() * static::TAX_RATE);
        return round($this->tax_total, 2);
    }
}
