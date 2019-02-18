<?php

namespace Appleton\Taxes\Countries\US\NewYork\Yonkers\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\NewYork\Yonkers\Yonkers as BaseYonkers;
use Appleton\Taxes\Models\Countries\US\NewYork\NewYorkIncomeTaxInformation;

class Yonkers extends BaseYonkers
{
    const NONRESIDENT_TAX_RATE = 0.005;
    const SUPPLEMENTAL_TAX_RATE = 0.0161135;

    const SINGLE_BRACKETS = [
        [0, 0.0400, 0],
        [8500, 0.0450, 340],
        [11700, 0.0525, 484],
        [13900, 0.0590, 600],
        [21400, 0.0633, 1042],
        [80650 , 0.0657, 4793],
        [96800, 0.0758, 5854],
        [107650, 0.0808, 6676],
        [157650, 0.0707, 10716],
        [215400, 0.0856, 14799],
        [265400, 0.0735, 19079],
        [1077550, 0.5208, 78772],
        [1127550, 0.0962, 104812],
    ];

    const MARRIED_BRACKETS = [
        [0, 0.0400, 0],
        [8500, 0.0450, 340],
        [11700, 0.0525, 484],
        [13900, 0.0590, 600],
        [21400, 0.0633, 1042],
        [80650 , 0.0657, 4793],
        [96800, 0.0783, 5854],
        [107650, 0.0833, 6703],
        [157650, 0.0785, 10868],
        [211550, 0.0707, 15099],
        [323200, 0.0916, 22993],
        [373200, 0.0735, 27573],
        [1077550, 0.0765, 79343],
        [2155350, 0.9454, 161794],
        [2205350, 0.0962, 209064],
    ];

    const SINGLE_DEDUCTION_ALLOWANCE_AMOUNT = 7400;

    const MARRIED_DEDUCTION_ALLOWANCE_AMOUNT = 7950;

    const EXEMPTION_ALLOWANCE_AMOUNT = 1000;

    public function __construct(NewYorkIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($tax_information, $payroll);
        $this->tax_information = $tax_information;
    }

    public function getAdjustedEarnings()
    {
        return $this->getGrossEarnings() - $this->getExemptionAllowance() - $this->getDeductionAllowance();
    }

    public function getTaxBrackets()
    {
        if ($this->tax_information->filing_status === static::FILING_SINGLE) {
            return static::SINGLE_BRACKETS;
        } else {
            return static::MARRIED_BRACKETS;
        }
    }

    private function getExemptionAllowance()
    {
        return $this->tax_information->exemptions * self::EXEMPTION_ALLOWANCE_AMOUNT;
    }

    public function getDeductionAllowance()
    {
        if ($this->tax_information->filing_status === static::FILING_SINGLE) {
            return self::SINGLE_DEDUCTION_ALLOWANCE_AMOUNT;
        } else {
            return self::MARRIED_DEDUCTION_ALLOWANCE_AMOUNT;
        }
    }

    private function getGrossEarnings()
    {
        return ($this->payroll->earnings - $this->payroll->supplemental_earnings) * $this->payroll->pay_periods;
    }
}
