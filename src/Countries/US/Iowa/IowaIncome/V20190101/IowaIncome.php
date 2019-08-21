<?php
namespace Appleton\Taxes\Countries\US\Iowa\IowaIncome\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Iowa\IowaIncome\IowaIncome as BaseIowaIncome;
use Appleton\Taxes\Models\Countries\US\Iowa\IowaIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

class IowaIncome extends BaseIowaIncome
{
    const TAX_RATE = 0.0495;
    const DEDUCTION_AMOUNT = 40;
    const ZERO_OR_ONE = 1690;
    const TWO_OR_MORE = 4160;

    const TAX_WITHHOLDING_BRACKET = [
        [0, 0.0033, 0],
        [1333, .0067, 4.4],
        [2666, .0225, 13.33],
        [5331, .0414, 73.29],
        [11995, .0563, 349.18],
        [19992, .0596, 799.41],
        [26656, .0625, 1196.58],
        [39984, .0744, 2029.58],
        [59976, .0853, 3516.98],
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

        $this->tax_total = $this->payroll->withholdTax(($this->getTaxAmountFromTaxBrackets($this->getGrossAnyWages() - $this->getStandardAllowance(), $this->getTaxBrackets()) - $this->getExemptionAllowance()) / $this->payroll->pay_periods);

        return round($this->tax_total, 2);
    }

    public function getGrossAnyWages()
    {
        return (($this->getAdjustedEarnings() * $this->payroll->pay_periods) - ($this->federal_income_tax * $this->payroll->pay_periods));
    }

    public function getStandardAllowance()
    {
        return $this->tax_information->allowances <= 1 ? self::ZERO_OR_ONE : self::TWO_OR_MORE;
    }

    public function getExemptionAllowance()
    {
        return self::DEDUCTION_AMOUNT * $this->tax_information->allowances;
    }
}
