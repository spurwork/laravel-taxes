<?php
namespace Appleton\Taxes\Countries\US\Nebraska\NebraskaIncome\V20190101;

use Appleton\Taxes\Countries\US\Nebraska\NebraskaIncome\NebraskaIncome as BaseNebraskaIncome;
use Illuminate\Database\Eloquent\Collection;

class NebraskaIncome extends BaseNebraskaIncome
{
    const EXEMPTION_ALLOWANCE = 1960;

    const SINGLE_TAX_WITHHOLDING_BRACKET = [
        [0, .0, 0],
        [2975, .0226, 0],
        [5480, .0322, 56.61],
        [17790, .0491, 452.99],
        [25780, .062, 845.3],
        [32730, .0659, 1276.2],
        [61470, .0695, 3170.17],
    ];

    const MARRIED_TAX_WITHHOLDING_BRACKET = [
        [0, .0, 0],
        [7100, .0226, 0],
        [10610, .0322, 79.33],
        [26420, .0491, 588.41],
        [41100, .062, 1309.2],
        [50990, .0659, 1922.38],
        [67620, .0695, 3018.3],
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

        $this->tax_total = ($this->getTaxAmountFromTaxBrackets($this->getGrossWages() - $this->getExemptionAllowances(), $this->getTaxBrackets()) / $this->payroll->pay_periods);

        if ((!$this->tax_information->lower_withholding_than_lb223 && ($this->tax_information->filing_status === 'S' && $this->tax_information->allowances > 1)) || (!$this->tax_information->lower_withholding_than_lb223 && $this->tax_information->filing_status === 'M' && $this->tax_information->allowances > 2)) {
            $exemptions = 0;
            if ($this->tax_information->filing_status === 'S' || $this->tax_information->filing_status === 'H') {
                $exemption = self::EXEMPTION_ALLOWANCE;
            } else {
                $exemption = self::EXEMPTION_ALLOWANCE * 2;
            }

            $this->tax_total = max($this->tax_total, (($this->getTaxAmountFromTaxBrackets($this->getGrossWages() - $exemptions, $this->getTaxBrackets()) / $this->payroll->pay_periods) * .5));
        }

        $this->payroll->withholdTax($this->tax_total);
        return round($this->tax_total, 2);
    }

    public function getGrossWages()
    {
        return $this->getAdjustedEarnings() * $this->payroll->pay_periods;
    }

    public function getExemptionAllowances()
    {
        return $this->tax_information->allowances * self::EXEMPTION_ALLOWANCE;
    }
}
