<?php
namespace Appleton\Taxes\Countries\US\Kentucky\AugustaCity\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\AugustaCity\AugustaCity as BaseAugustaCity;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

class AugustaCity extends BaseAugustaCity
{
    use HasWageBase;

    public const TAX_RATE = 0.0125;
    const WAGE_BASE = 72000;

    public function compute(Collection $tax_areas)
    {
        $this->tax_total = $this->payroll->withholdTax($this->getBaseEarningsWageBase() * static::TAX_RATE);
        return round($this->tax_total, 2);
    }
}
