<?php
namespace Appleton\Taxes\Countries\US\Mississippi\MississippiIncome\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Mississippi\MississippiIncome\MississippiIncome as BaseMississippiIncome;
use Appleton\Taxes\Models\Countries\US\Mississippi\MississippiIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

class MississippiIncome extends BaseMississippiIncome
{
    const TAX_RATE = 0.05;
    const SINGLE_DEDUCTION = 2300;
    const HEAD_OF_HOUSEHOLD_DEDUCTION = 3400;
    const MARRIED_DEDUCTION = 4600;

    const TAX_WITHHOLDING_BRACKET = [
        [0, 0, 0],
        [2000, .03, 0],
        [5000, .04, 90],
        [10000, .05, 290],
    ];

    public function compute(Collection $tax_areas)
    {
        if ($this->isUserClaimingExemption()) {
            return 0;
        }

        $this->tax_total = $this->payroll->withholdTax($this->getTaxAmountFromTaxBrackets(($this->getAdjustedEarnings() * $this->payroll->pay_periods) - $this->tax_information->personal_exemptions - $this->getTaxBrackets(), SELF::TAX_WITHHOLDING_BRACKET) / $this->payroll->pay_periods) + $this->getAdditionalWithholding();

        return (int)round(intval($this->tax_total * 100) / 100, 0);
    }

    public function getTaxBrackets()
    {
        if ($this->tax_information->filing_status === static::FILING_MARRIED) {
            return self::MARRIED_DEDUCTION;
        } elseif ($this->tax_information->filing_status === static::FILING_HEAD_OF_HOUSEHOLD) {
            return self::HEAD_OF_HOUSEHOLD_DEDUCTION;
        } else {
            return self::SINGLE_DEDUCTION;
        }
    }

    public function getAdditionalWithholding()
    {
        return $this->tax_information->additional_withholding;
    }
}
