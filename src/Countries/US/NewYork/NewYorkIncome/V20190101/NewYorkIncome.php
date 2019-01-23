<?php

namespace Appleton\Taxes\Countries\US\NewYork\NewYorkIncome\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\NewYork\NewYorkIncome\NewYorkIncome as BaseNewYorkIncome;
use Appleton\Taxes\Models\Countries\US\NewYork\NewYorkIncomeTaxInformation;

class NewYorkIncome extends BaseNewYorkIncome
{
    const SUPPLEMENTAL_TAX_RATE = 0.049;

    const SINGLE_BRACKETS = [
        [0, 0.0400, 0],
        [8500, 0.0450, 340],
        [11700, 0.0525, 484],
        [13900, 0.0590, 600],
        [21400, 0.0621, 1042],
        [80650 , 0.0649, 4721],
        [96800, 0.0752, 5770],
        [107650, 0.0802, 6585],
        [157650, 0.0699, 10595],
        [215400, 0.0890, 14632],
        [265400, 0.0735, 19082],
        [1077550, 0.5208, 78775],
        [1127550, 0.0962, 104815],
    ];

    const MARRIED_BRACKETS = [
        [0, 0.0400, 0],
        [8500, 0.0450, 340],
        [11700, 0.0525, 484],
        [13900, 0.0590, 600],
        [21400, 0.0621, 1042],
        [80650 , 0.0649, 4721],
        [96800, 0.0764, 5770],
        [107650, 0.0814, 6599],
        [157650, 0.0790, 10669],
        [211550, 0.0699, 14927],
        [323200, 0.0968, 22731],
        [373200, 0.0735, 27571],
        [1077550, 0.0765, 79341],
        [2155350, 0.9454, 161792],
        [2205350, 0.0962, 209062],
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
        if ($this->tax_information->filing_status === static::FILING_SINGLE || $this->tax_information->filing_status === static::FILING_HEAD_OF_HOUSEHOLD) {
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
        if ($this->tax_information->filing_status === static::FILING_SINGLE || $this->tax_information->filing_status === static::FILING_HEAD_OF_HOUSEHOLD) {
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
