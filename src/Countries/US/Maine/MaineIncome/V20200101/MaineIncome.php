<?php
namespace Appleton\Taxes\Countries\US\Maine\MaineIncome\V20200101;

use Appleton\Taxes\Countries\US\Maine\MaineIncome\MaineIncome as BaseMaineIncome;
use Illuminate\Database\Eloquent\Collection;

class MaineIncome extends BaseMaineIncome
{
    protected $gross_wages = 0;

    const PERSONAL_ALLOWANCE = 4300;

    const SINGLE_TAX_WITHHOLDING_BRACKET = [
        [0, .058, 0],
        [22200, .0675, 1288],
        [52600, .0715, 3340],
    ];

    const MARRIED_TAX_WITHHOLDING_BRACKET = [
        [0, .058, 0],
        [44450, .0675, 2578],
        [105200, .0715, 6679],
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
        if ($this->tax_information->filing_status === 'S' && $this->gross_wages <= 82900) {
            return 9550;
        } elseif ($this->tax_information->filing_status === 'S' && $this->gross_wages > 157900) {
            return 0;
        } elseif ($this->tax_information->filing_status === 'S' && $this->gross_wages > 82900 && $this->gross_wages <= 157900) {
            return round(9550 * (157900 - $this->gross_wages) / 75000, 4);
        }

        if ($this->tax_information->filing_status === 'M' && $this->gross_wages <= 165800) {
            return 21950;
        } elseif ($this->tax_information->filing_status === 'M' && $this->gross_wages > 315800) {
            return 0;
        } elseif ($this->tax_information->filing_status === 'M' && $this->gross_wages > 165800 && $this->gross_wages <= 315800) {
            return round(21950 * (315800 - $this->gross_wages) / 150000, 4);
        }
    }

    public function getAnnualWageAmount()
    {
        $annual_wage_amount = $this->gross_wages - $this->getPersonalAllowance() - $this->getStandardDeduction();

        return $annual_wage_amount > 0 ? $annual_wage_amount : 0;
    }
}
