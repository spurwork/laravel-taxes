<?php
namespace Appleton\Taxes\Countries\US\WashingtonDC\WashingtonDCIncome\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\WashingtonDC\WashingtonDCIncome\WashingtonDCIncome as BaseWashingtonDCIncome;
use Appleton\Taxes\Models\Countries\US\WashingtonDC\WashingtonDCIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

class WashingtonDCIncome extends BaseWashingtonDCIncome
{
    const TAX_RATE = 0.0895;

    const TAX_WITHHOLDING_BRACKET = [
        [0, .04, 0],
        [10000, .06, 400],
        [40000, .065, 2200],
        [60000, .085, 3500],
        [350000, .0875, 28150],
        [10000000, .0895, 85025],
    ];

    public function compute(Collection $tax_areas)
    {
        if ($this->isUserClaimingExemption()) {
            return 0;
        }

        $this->tax_total = $this->payroll->withholdTax($this->getTaxAmountFromTaxBrackets(($this->getAdjustedEarnings() * $this->payroll->pay_periods) - $this->getDependentAllowance(), SELF::TAX_WITHHOLDING_BRACKET) / $this->payroll->pay_periods) + $this->getAdditionalWithholding();

        return round(intval($this->tax_total * 100) / 100, 2);
    }

    public function getDependentAllowance()
    {
        return $this->tax_information->dependents * 4150;
    }

    public function getTaxBrackets()
    {
        return [[0, self::TAX_RATE, 0]];
    }
}
