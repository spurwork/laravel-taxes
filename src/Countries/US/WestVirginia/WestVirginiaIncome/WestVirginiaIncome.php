<?php

namespace Appleton\Taxes\Countries\US\WestVirginia\WestVirginiaIncome;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateIncome;
use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Models\Countries\US\WestVirginia\WestVirginiaIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

/**
 * Tax Calculation:
 * 1. Subtract exemptions
 * 2. Use tax tables
 * 3. Round to the nearest dollar
 */
abstract class WestVirginiaIncome extends BaseStateIncome
{
    public function __construct(WestVirginiaIncomeTaxInformation $tax_information,
                                Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }

    public function getSupplementalIncomeTax()
    {
        return $this->getSupplementalAmount($this->payroll->getSupplementalEarnings(),
            $this->getSupplementalBrackets());
    }

    public function getTaxBrackets()
    {
        return ($this->tax_information->two_earner_percent)
            ? $this->getTwoEarnerBrackets() : $this->getOneEarnerBrackets();
    }

    public function getAdjustedEarnings()
    {
        return $this->payroll->getEarnings() * $this->payroll->pay_periods - $this->getExemptionCredit();
    }

    public function compute(Collection $tax_areas)
    {
        if ($this->isUserClaimingExemption()) {
            return 0.00;
        }

        $tax_amount = round($this->getTaxAmountFromTaxBrackets($this->getAdjustedEarnings(), $this->getTaxBrackets())
            / $this->payroll->pay_periods);
        $this->tax_total = $this->payroll->withholdTax($tax_amount) +
            $this->payroll->withholdTax($this->getSupplementalIncomeTax()) +
            $this->payroll->withholdTax($this->getAdditionalWithholding());

        return round(((int)($this->tax_total * 100)) / 100, 2);
    }

    abstract protected function getOneEarnerBrackets(): array;

    abstract protected function getTwoEarnerBrackets(): array;

    abstract protected function getExemptionsAllowance(): int;

    abstract protected function getSupplementalBrackets(): array;

    private function getSupplementalAmount($amount, $table)
    {
        $bracket = $this->getTaxBracket($amount, $table);
        $tax_amount = isset($bracket) ? $amount * $bracket[1] : 0;

        return $tax_amount > 0 ? $tax_amount : 0;
    }

    private function getExemptionCredit(): int
    {
        return $this->tax_information->allowances * $this->getExemptionsAllowance();
    }
}
