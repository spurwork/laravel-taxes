<?php

namespace Appleton\Taxes\Countries\US\RhodeIsland\RhodeIslandIncome\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\RhodeIsland\RhodeIslandIncome\RhodeIslandIncome as BaseRhodeIslandIncome;
use Appleton\Taxes\Models\Countries\US\RhodeIsland\RhodeIslandIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

class RhodeIslandIncome extends BaseRhodeIslandIncome
{
    public function compute(Collection $tax_areas)
    {
        if ($this->isUserClaimingExemption()) {
            return 0.00;
        }

        $this->tax_total = $this->payroll->withholdTax($this->getTaxAmountFromTaxBrackets($this->getAnnualTaxAmount(), $this->getTaxBrackets()) / $this->payroll->pay_periods + $this->tax_information->additional_withholding);

        return round($this->tax_total, 2);
    }

    public function getGrossWages()
    {
        return $this->getAdjustedEarnings() * $this->payroll->pay_periods;
    }

    public function getAnnualTaxAmount()
    {
        $gross_wages = $this->getGrossWages();

        return $gross_wages < self::EXEMPTION_GROSS_WAGES ? $gross_wages - ($this->tax_information->exemptions * self::EXEMPTION_AMOUNT) : $gross_wages;
    }

    public function getTaxBrackets()
    {
        return self::TAX_WITHHOLDING_AMOUNT;
    }
}
