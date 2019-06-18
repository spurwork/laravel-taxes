<?php
 namespace Appleton\Taxes\Countries\US\Louisiana\LouisianaIncome\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Louisiana\LouisianaIncome\LouisianaIncome as BaseLouisianaIncome;
use Appleton\Taxes\Models\Countries\US\Louisiana\LouisianaIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

class LouisianaIncome extends BaseLouisianaIncome
{
    const SUPPLEMENTAL_TAX_RATE = 0;
    const TAX_RATE = 0.04;

    public function __construct(LouisianaIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($tax_information, $payroll);
    }

    public function compute(Collection $tax_areas)
    {
        if ($this->isUserClaimingExemption()) {
            return 0.00;
        }

        $this->tax_total = $this->payroll->withholdTax($this->getWithholdingTaxPerPayPeriod());

        return round(intval($this->tax_total * 100) / 100, 2);
    }

    public function getTaxBrackets()
    {
        return [[0, self::TAX_RATE, 0]];
    }

    public function dependents()
    {
        return $this->tax_information->dependents * 1000;
    }

    public function personalExemptions()
    {
        return $this->tax_information->exemptions * 4500;
    }

    public function getPartA()
    {
        $sub_total = $this->dependents() + $this->personalExemptions();
        if ($sub_total < 0) {
            return 0;
        }

        $total = (0.021 * ($sub_total / $this->payroll->pay_periods));

        return $total > 0 ? $total : 0;
    }

    public function getPartB()
    {
        if ($this->tax_information->filing_status === 'M') {
            $total = (($this->dependents() + $this->personalExemptions()) - 25000);

            if ($total < 0) {
                return 0;
            }

            return (0.0165 * ($total / $this->payroll->pay_periods));
        } else {
            $total = (($this->dependents() + $this->personalExemptions()) - 12500);

            if ($total < 0) {
                return 0;
            }

            return (0.016 * ($total / $this->payroll->pay_periods));
        }
    }

    public function getWithholdingTaxPerPayPeriod()
    {
        if ($this->tax_information->filing_status === 'S') {
            if ($this->getAdjustedEarnings() <= 12500) {
                $total = (0.021 * $this->payroll->getEarnings()) - ($this->getPartA() + $this->getPartB());
            } elseif ($this->getAdjustedEarnings() > 12500 && $this->getAdjustedEarnings() <= 50000) {
                $total = (0.021 * $this->payroll->getEarnings()) + (0.016 * ($this->payroll->getEarnings() - (12500 / $this->payroll->pay_periods))) - ($this->getPartA() + $this->getPartB());
            } elseif ($this->getAdjustedEarnings() > 50000) {
                $total = (0.021 * $this->payroll->getEarnings()) + (0.016 * ($this->payroll->getEarnings() - (12500 / $this->payroll->pay_periods))) + (0.0135 * ($this->payroll->getEarnings() - (50000 / $this->payroll->pay_periods))) - ($this->getPartA() + $this->getPartB());
            }
        } else {
            if ($this->getAdjustedEarnings() <= 25000) {
                $total = (0.021 * $this->payroll->getEarnings()) - ($this->getPartA() + $this->getPartB());
            } elseif ($this->getAdjustedEarnings() > 25000 && $this->getAdjustedEarnings() <= 100000) {
                $total = (0.021 * $this->payroll->getEarnings()) + (0.0165 * ($this->payroll->getEarnings() - (25000 / $this->payroll->pay_periods))) - ($this->getPartA() + $this->getPartB());
            } elseif ($this->getAdjustedEarnings() > 100000) {
                $total = (0.021 * $this->payroll->getEarnings()) + (0.0165 * ($this->payroll->getEarnings() - (25000 / $this->payroll->pay_periods))) + (0.0135 * ($this->payroll->getEarnings() - (100000 / $this->payroll->pay_periods))) - ($this->getPartA() + $this->getPartB());
            }
        }
        return $total > 0 ? $total : 0;
    }

    public function getAdjustedEarnings(): int
    {
        $gross_wages = $this->payroll->getEarnings() * $this->payroll->pay_periods;
        return $gross_wages;
    }
}
