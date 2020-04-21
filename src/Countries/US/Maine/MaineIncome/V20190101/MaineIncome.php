<?php
namespace Appleton\Taxes\Countries\US\Maine\MaineIncome\V20190101;

use Appleton\Taxes\Countries\US\Maine\MaineIncome\MaineIncome as BaseMaineIncome;
use Illuminate\Database\Eloquent\Collection;

class MaineIncome extends BaseMaineIncome
{
    protected $gross_wages = 0;

    const PERSONAL_ALLOWANCE = 4200;

    const SINGLE_TAX_WITHHOLDING_BRACKET = [
        [0, .058, 0],
        [21850, .0675, 1267],
        [51700, .0715, 3282],
    ];

    const MARRIED_TAX_WITHHOLDING_BRACKET = [
        [0, .058, 0],
        [43700, .0675, 2535],
        [103400, .0715, 6565],
    ];

    public function getTaxBrackets()
    {
        if ($this->tax_information->filing_status === 'S') {
            return self::SINGLE_TAX_WITHHOLDING_BRACKET;
        }
        return self::MARRIED_TAX_WITHHOLDING_BRACKET;
    }

    public function compute(Collection $tax_areas)
    {
        if ($this->isUserClaimingExemption()) {
            return 0;
        }

        $this->gross_wages = $this->getGrossWages();

        if ($this->getAnnualWageAmount() > 0) {
            $this->tax_total = $this->payroll->withholdTax($this->getTaxAmountFromTaxBrackets($this->getAnnualWageAmount(), $this->getTaxBrackets()) / $this->payroll->pay_periods) + $this->getAdditionalWithholding();

            return (int)round(intval($this->tax_total * 100) / 100, 0);
        }

        $this->tax_total = 0;
        return $this->tax_total;
    }

    public function getGrossWages()
    {
        return $this->getAdjustedEarnings() * $this->payroll->pay_periods;
    }

    public function getPersonalAllowance()
    {
        return $this->tax_information->allowances * self::PERSONAL_ALLOWANCE;
    }

    public function getStandardDeduction()
    {
        if ($this->tax_information->filing_status === 'S' && $this->gross_wages <= 81540) {
            return 9350;
        } elseif ($this->tax_information->filing_status === 'S' && $this->gross_wages > 156450) {
            return 0;
        } elseif ($this->tax_information->filing_status === 'S' && $this->gross_wages > 81540 && $this->gross_wages <= 156450) {
            return round(9350 * (156450 - $this->gross_wages) / 75000, 4);
        }

        if ($this->tax_information->filing_status === 'M' && $this->gross_wages <= 162950) {
            return 21550;
        } elseif ($this->tax_information->filing_status === 'M' && $this->gross_wages > 312950) {
            return 0;
        } elseif ($this->tax_information->filing_status === 'M' && $this->gross_wages > 162950 && $this->gross_wages <= 312950) {
            return round(21550 * (312950 - $this->gross_wages) / 150000, 4);
        }
    }

    public function getAnnualWageAmount()
    {
        $annual_wage_amount = $this->gross_wages - $this->getPersonalAllowance() - $this->getStandardDeduction();

        return $annual_wage_amount > 0 ? $annual_wage_amount : 0;
    }
}
