<?php

namespace Appleton\Taxes\Countries\US\Maryland\MarylandIncome\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\Maryland\MarylandIncome\MarylandIncome as BaseMarylandIncome;
use Appleton\Taxes\Models\Countries\US\Maryland\MarylandIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

class MarylandIncome extends BaseMarylandIncome
{
    const SUPPLEMENTAL_TAX_RATE = 0.05;

    private const TAX_RATE = 0.05;
    private $worked_in_delaware = false;

    const SINGLE_BRACKETS_DELAWARE = [
        [0, 0.065, 0],
        [100000, 0.0675, 6500.00],
        [125000, 0.07, 8187.50],
        [150000, 0.0725, 9937.50],
        [250000, 0.75, 17187.50]
    ];

    const MARRIED_BRACKETS_DELAWARE = [
        [0, 0.065, 0],
        [15000, 0.0675, 9750.00],
        [175000, 0.07, 11437.50],
        [225000, 0.0725, 14937.50],
        [300000, 0.75, 20375.00],
    ];

    const SINGLE_BRACKETS = [
        [0, 0.0475, 0],
        [100000, 0.05, 4750.00],
        [125000, 0.0525, 6000.00],
        [150000, 0.055, 7312.50],
        [250000, 0.0575, 12812.50],
    ];

    const MARRIED_BRACKETS = [
        [0, 0.0475, 0],
        [150000, 0.05, 7125.00],
        [175000, 0.0525, 8375.00],
        [225000, 0.0525, 11000.00],
        [300000, 0.575, 15125.00],
    ];

    const STANDARD_DEDUCTION = [
        'min' => 1500,
        'max' => 2250,
        'percentange' => 0.015,
    ];

    public function __construct(MarylandIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($tax_information, $payroll);
    }

    public function getTaxBrackets()
    {
        if ($this->worked_in_delaware) {
            if ($this->tax_information->filing_status === static::FILING_MARRIED_HEAD_OF_HOUSEHOLD) {
                return static::MARRIED_BRACKETS_DELAWARE;
            }
            return static::SINGLE_BRACKETS_DELAWARE;
        }

        // change if worked in delaware
        if ($this->tax_information->filing_status === static::FILING_MARRIED_HEAD_OF_HOUSEHOLD) {
            return static::MARRIED_BRACKETS;
        }
        return static::SINGLE_BRACKETS;
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
            return $tax_area->homeGovernmentalUnitArea->id !== $tax_area->workGovernmentalUnitArea->id;
        });

        $this->tax_total = $this->payroll->withholdTax($this->getTaxAmountFromTaxBrackets($this->getAdjustedEarnings(), $this->getTaxBrackets()) / $this->payroll->pay_periods) +
            $this->payroll->withholdTax($this->getSupplementalIncomeTax()) +
            $this->payroll->withholdTax($this->getAdditionalWithholding());

        return round(intval($this->tax_total * 100) / 100, 2);
    }
}