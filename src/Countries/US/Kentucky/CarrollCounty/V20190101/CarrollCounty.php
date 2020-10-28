<?php

namespace Appleton\Taxes\Countries\US\Kentucky\CarrollCounty\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\CarrollCounty\CarrollCounty as BaseCarrollCounty;
use Illuminate\Database\Eloquent\Collection;

class CarrollCounty extends BaseCarrollCounty
{
    private const TAX_RATE = 0.01;
    private const MIN_WAGES = 5000;
    private const MAX_TAX = 50000;

    public function compute(Collection $tax_areas)
    {
        $taxable_amount = 0;
        $earnings = $this->payroll->getEarnings();
        $ytd_earnings = $this->payroll->getYtdEarnings($tax_areas->first()->workGovernmentalUnitArea);
        $ytd_taxable_wages = $this->payroll->getYtdTaxableWages(BaseCarrollCounty::class);

        if ($earnings + $ytd_earnings <= self::MIN_WAGES || $ytd_taxable_wages >= self::MAX_TAX) {
            return 0.0;
        }

        if ($ytd_earnings < self::MIN_WAGES) {
            $earnings = $earnings - (self::MIN_WAGES - $ytd_earnings);
        }

        $taxable_amount = min($earnings * self::TAX_RATE, self::MAX_TAX - $ytd_taxable_wages);

        return round($this->payroll->withholdTax($taxable_amount), 2);
    }
}
