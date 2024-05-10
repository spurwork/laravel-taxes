<?php
namespace Appleton\Taxes\Countries\US\WashingtonDC\WashingtonDCIncome\V20190101;

use Appleton\Taxes\Countries\US\WashingtonDC\WashingtonDCIncome\WashingtonDCIncome as BaseWashingtonDCIncome;

class WashingtonDCIncome extends BaseWashingtonDCIncome
{
    const TAX_WITHHOLDING_BRACKET = [
        [0, .04, 0],
        [10000, .06, 400],
        [40000, .065, 2200],
        [60000, .085, 3500],
        [350000, .0875, 28150],
        [10000000, .0895, 85025],
    ];

    public function getAdjustedEarnings()
    {
        return ($this->payroll->getEarnings() * $this->payroll->pay_periods)
            - $this->getDependentAllowance();
    }

    public function getDependentAllowance()
    {
        return $this->tax_information->dependents * 4150;
    }

    public function getTaxBrackets()
    {
        return self::TAX_WITHHOLDING_BRACKET;
    }
}
