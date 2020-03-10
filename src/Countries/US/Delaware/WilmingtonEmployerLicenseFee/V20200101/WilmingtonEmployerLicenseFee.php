<?php

namespace Appleton\Taxes\Countries\US\Delaware\WilmingtonEmployerLicenseFee\V20200101;

use Appleton\Taxes\Countries\US\Delaware\WilmingtonEmployerLicenseFee\WilmingtonEmployerLicenseFee as BaseWilmingtonEmployerLicenseFee;

use Illuminate\Database\Eloquent\Collection;

class WilmingtonEmployerLicenseFee extends BaseWilmingtonEmployerLicenseFee
{
    const LICENSE_FEE = 15;

    public function compute(Collection $tax_areas)
    {
        $wilmington = $tax_areas->first()->workGovernmentalUnitArea;

        $wilmington_mtd_earnings = $this->payroll->getMtdEarnings($wilmington);
        $this->tax_total = $wilmington_mtd_earnings === 0.0 ? $this->payroll->withholdTax(self::LICENSE_FEE) : 0.0;

        return round($this->tax_total, 2);
    }
}
