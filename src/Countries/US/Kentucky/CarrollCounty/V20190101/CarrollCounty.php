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
        $earnings = $this->payroll->getEarnings();
        $ytd_taxable_earnings = $this->payroll->getYtdTaxableWages(BaseCarrollCounty::class);

        if ($ytd_taxable_earnings === 0.0) {
            $ytd_earnings = $this->payroll->getYtdEarnings($tax_areas->first()->workGovernmentalUnitArea);
            if ($earnings + $ytd_earnings <= self::MIN_WAGES) {
                return 0.0;
            }

            $taxable_earnings = $earnings + $ytd_earnings - self::MIN_WAGES;
        } else {
            $taxable_earnings = $earnings;
        }

        if ($ytd_taxable_earnings >= self::MAX_TAX) {
            return 0.0;
        } elseif ($taxable_earnings * self::TAX_RATE + $ytd_taxable_earnings > self::MAX_TAX) {
            $taxable_earnings = $taxable_earnings * self::TAX_RATE + $ytd_taxable_earnings - self::MAX_TAX;

            $tax_amount = round($taxable_earnings, 2);
            return round($this->payroll->withholdTax($tax_amount), 2);
        }

        $tax_amount = round($taxable_earnings * self::TAX_RATE, 2);

        return round($this->payroll->withholdTax($tax_amount), 2);
    }
}
