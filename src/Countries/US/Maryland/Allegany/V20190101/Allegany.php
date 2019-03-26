<?php

namespace Appleton\Taxes\Countries\US\Maryland\Allegany\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Maryland\Allegany\Allegany as BaseAllegany;
use Appleton\Taxes\Models\Countries\US\Maryland\MarylandIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;


class Allegany extends BaseAllegany
{
    const SUPPLEMENTAL_TAX_RATE = 0.05;
    private const TAX_RATE = 0.0305;

    const STANDARD_DEDUCTION = [
        'min' => 1500,
        'max' => 2250,
        'percentange' => 0.015,
    ];

    public function __construct(MarylandIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }

    public function getTaxBrackets()
    {
        return [[0, self::TAX_RATE, 0]];
    }

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