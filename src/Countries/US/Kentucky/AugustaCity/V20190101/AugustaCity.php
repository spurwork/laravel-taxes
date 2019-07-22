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
        return round($this->payroll->withholdTax(min($this->payroll->getEarnings(), $this->getBaseEarnings($tax_areas->first()->workGovernmentalUnitArea)) * self::TAX_RATE), 2);
    }
}
