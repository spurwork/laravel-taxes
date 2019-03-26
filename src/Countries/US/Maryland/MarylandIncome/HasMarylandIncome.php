<?php

namespace Appleton\Taxes\Countries\US\Maryland\MarylandIncome;

use Illuminate\Database\Eloquent\Collection;

trait HasMarylandIncome
{
    public function getAdjustedEarnings()
    {
        return $this->getGrossEarnings() - $this->getStandardDeduction() - $this->getDependentExemption();
    }

    private function getStandardDeduction()
    {
        $amount = $this->getGrossEarnings() * self::STANDARD_DEDUCTION['percentange'];
        if ($amount < self::STANDARD_DEDUCTION['min']) {
            $amount = self::STANDARD_DEDUCTION['min'];
        }
        if ($amount > self::STANDARD_DEDUCTION['max']) {
            $amount = self::STANDARD_DEDUCTION['max'];
        }

        return $amount;
    }

    private function getGrossEarnings()
    {
        // change if worked in delaware
        $markup = $this->worked_in_delaware ? 1.032 : 1;
        return $this->payroll->getEarnings() * $this->payroll->pay_periods * $markup;
    }

    private function getDependentExemption()
    {
        $amount = 3200 * $this->tax_information->dependents;
        return $amount;
    }

    public function compute(Collection $tax_areas)
    {
        if ($this->isUserClaimingExemption())
        {
            return 0.00;
        }

        $this->worked_in_delaware = $tax_areas->contains(function($tax_area) {
            return ($tax_area->homeGovernmentalUnitArea && $tax_area->workGovernmentalUnitArea)
                && $tax_area->homeGovernmentalUnitArea->id !== $tax_area->workGovernmentalUnitArea->id;
        });

        $this->tax_total = $this->payroll->withholdTax($this->getTaxAmountFromTaxBrackets($this->getAdjustedEarnings(), $this->getTaxBrackets()) / $this->payroll->pay_periods) +
            $this->payroll->withholdTax($this->getSupplementalIncomeTax()) +
            $this->payroll->withholdTax($this->getAdditionalWithholding());

        return round(intval($this->tax_total * 100) / 100, 2);
    }
}