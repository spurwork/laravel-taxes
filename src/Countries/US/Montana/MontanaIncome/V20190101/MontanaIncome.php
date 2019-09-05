<?php
namespace Appleton\Taxes\Countries\US\Montana\MontanaIncome\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Montana\MontanaIncome\MontanaIncome as BaseMontanaIncome;
use Appleton\Taxes\Models\Countries\US\Montana\MontanaIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

class MontanaIncome extends BaseMontanaIncome
{
    const WITHHOLDING_ALLOWANCE = 1900;

    const TAX_WITHHOLDING_BRACKET = [
        [0, .018, 0],
        [7000, .044, 126],
        [15000, .06, 478],
        [120000, .066, 6778],
    ];

    public function getTaxBrackets()
    {
        return self::TAX_WITHHOLDING_BRACKET;
    }

    public function compute(Collection $tax_areas)
    {
        if ($this->isUserClaimingExemption()) {
            return 0;
        }

        $this->tax_total = $this->payroll->withholdTax($this->getTaxAmountFromTaxBrackets($this->getGrossWages() - $this->getStandardAllowance(), $this->getTaxBrackets()) / $this->payroll->pay_periods);

        return (int)round(intval($this->tax_total * 100) / 100, 0);
    }

    public function getGrossWages()
    {
        return $this->getAdjustedEarnings() * $this->payroll->pay_periods;
    }

    public function getStandardAllowance()
    {
        return $this->tax_information->allowances * self::WITHHOLDING_ALLOWANCE;
    }
}
