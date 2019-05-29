<?php

namespace Appleton\Taxes\Traits;

use Exception;
use Illuminate\Database\Eloquent\Collection;

trait HasIncome
{
    public function compute(Collection $tax_areas)
    {
        if ($this->isUserClaimingExemption()) {
            return 0.00;
        }

        $this->tax_total = $this->payroll->withholdTax($this->getTaxAmountFromTaxBrackets($this->getAdjustedEarnings(), $this->getTaxBrackets()) / $this->payroll->pay_periods) +
            $this->payroll->withholdTax($this->getSupplementalIncomeTax()) +
            $this->payroll->withholdTax($this->getAdditionalWithholding());

        return round(intval($this->tax_total * 100) / 100, 2);
    }

    public function getAdditionalWithholding()
    {
        return max(min($this->payroll->getNetEarnings(), $this->tax_information->additional_withholding), 0);
    }

    public function getSupplementalIncomeTax()
    {
        return $this->payroll->getSupplementalEarnings() * static::SUPPLEMENTAL_TAX_RATE;
    }

    public function getTaxAmountFromTaxBrackets($amount, $table)
    {
        $bracket = $this->getTaxBracket($amount, $table);
        $tax_amount = isset($bracket) ? ($amount - $bracket[0]) * $bracket[1] + $bracket[2] : 0;

        return $tax_amount > 0 ? $tax_amount : 0;
    }

    public function getTaxBracket($amount, $table)
    {
        $bracket = end($table);
        foreach ($table as $row) {
            if ($row[0] <= $amount) {
                $bracket = $row;
            }
        }

        return $bracket;
    }

    public function isUserClaimingExemption(): bool
    {
        return (bool)$this->tax_information->exempt;
    }

    public function resolveTaxInformation($information_type, $tax_information, $user)
    {
        if (!is_null($user) && is_null($tax_information)) {
            $tax_information = TaxInformation::forUser($this->user)->isTypeOf($information_type)->first();
        }

        if (is_null($tax_information)) {
            throw new Exception('Tax information could not be resolved.');
        }

        return $tax_information->information;
    }
}
