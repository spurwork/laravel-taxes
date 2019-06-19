<?php
 namespace Appleton\Taxes\Countries\US\Louisiana\LouisianaIncome\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Louisiana\LouisianaIncome\LouisianaIncome as BaseLouisianaIncome;
use Appleton\Taxes\Models\Countries\US\Louisiana\LouisianaIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

class LouisianaIncome extends BaseLouisianaIncome
{
    const TAX_RATE = 0.04;

    public $min_income_amount;
    public $max_income_amount;
    public $multiplier;

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

    public function getAdjustedEarnings(): int
    {
        $gross_wages = $this->payroll->getEarnings() * $this->payroll->pay_periods;
        return $gross_wages;
    }

    private function dependents(): int
    {
        return $this->tax_information->dependents * 1000;
    }

    private function personalExemptions(): int
    {
        return $this->tax_information->exemptions * 4500;
    }

    private function getMaritalStatus(): void
    {
        if ($this->tax_information->filing_status === 'M') {
            $this->min_income_amount = 25000;
            $this->max_income_amount = 100000;
            $this->multiplier = .0165;
        } else {
            $this->min_income_amount = 12500;
            $this->max_income_amount = 50000;
            $this->multiplier = .016;
        }
    }

    private function getPartA(): float
    {
        $sub_total = $this->dependents() + $this->personalExemptions();

        if ($sub_total < 0) {
            return 0;
        }

        $total = (0.021 * ($sub_total / $this->payroll->pay_periods));

        return $total > 0 ? $total : 0;
    }

    private function getPartB(): float
    {
        $total = (($this->dependents() + $this->personalExemptions()) - $this->min_income_amount);

        if ($total < 0) {
            return 0;
        }

        return ($this->multiplier * ($total / $this->payroll->pay_periods));
    }

    private function getWithholdingTaxPerPayPeriod(): float
    {
        $this->getMaritalStatus();

        $total = (0.021 * $this->payroll->getEarnings()) - ($this->getPartA() + $this->getPartB());

        if ($this->getAdjustedEarnings() <= $this->min_income_amount) {
            return $total > 0 ? $total : 0;
        }

        if ($this->getAdjustedEarnings() > $this->min_income_amount) {
            $total += ($this->multiplier * ($this->payroll->getEarnings() - ($this->min_income_amount / $this->payroll->pay_periods)));
        }

        if ($this->getAdjustedEarnings() > $this->max_income_amount) {
            $total += (0.0135 * ($this->payroll->getEarnings() - ($this->max_income_amount / $this->payroll->pay_periods)));
        }

        return $total > 0 ? $total : 0;
    }
}
