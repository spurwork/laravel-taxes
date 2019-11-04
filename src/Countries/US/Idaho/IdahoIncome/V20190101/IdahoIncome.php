<?php
namespace Appleton\Taxes\Countries\US\Idaho\IdahoIncome\V20190101;

use Appleton\Taxes\Countries\US\Idaho\IdahoIncome\IdahoIncome as BaseIdahoIncome;
use Illuminate\Database\Eloquent\Collection;

class IdahoIncome extends BaseIdahoIncome
{
    const EXEMPTION_ALLOWANCE = 2960;

    const SINGLE_TAX_WITHHOLDING_BRACKET = [
        [0, .0, 0],
        [12200, .01125, 0],
        [13741, .03125, 17],
        [15281, .03625, 65],
        [16822, .04625, 121],
        [18362, .05625, 192],
        [19903, .06625, 279],
        [23754, .06925, 534],
    ];

    const MARRIED_TAX_WITHHOLDING_BRACKET = [
        [0, .0, 0],
        [24400, .01125, 0],
        [27482, .03125, 35],
        [30562, .03625, 131],
        [33644, .04625, 243],
        [36724, .05625, 385],
        [39806, .06625, 558],
        [47508, .06925, 1068],
    ];

    public function getTaxBrackets()
    {
        if ($this->tax_information->filing_status === 'S' || $this->tax_information->filing_status === 'H') {
            return self::SINGLE_TAX_WITHHOLDING_BRACKET;
        }

        return self::MARRIED_TAX_WITHHOLDING_BRACKET;
    }

    public function compute(Collection $tax_areas)
    {
        if ($this->isUserClaimingExemption()) {
            return 0;
        }

        $this->tax_total = $this->payroll->withholdTax(($this->getTaxAmountFromTaxBrackets($this->getGrossWages() - $this->getExemptionAllowance(), $this->getTaxBrackets()) / $this->payroll->pay_periods) + $this->tax_information->additional_withholding);

        return (int)round(intval($this->tax_total * 100) / 100, 0);
    }

    public function getGrossWages()
    {
        return $this->getAdjustedEarnings() * $this->payroll->pay_periods;
    }

    public function getExemptionAllowance()
    {
        return $this->tax_information->exemptions * self::EXEMPTION_ALLOWANCE;
    }
}
