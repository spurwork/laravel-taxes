<?php

namespace Appleton\Taxes\Countries\US\Wisconsin\WisconsinIncome\V20180101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Wisconsin\WisconsinIncome\WisconsinIncome as BaseWisconsinIncome;
use Appleton\Taxes\Models\Countries\US\Wisconsin\WisconsinIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

class WisconsinIncome extends BaseWisconsinIncome
{
    public function __construct(WisconsinIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($tax_information, $payroll);
        $this->tax_information = $tax_information;
    }

    public function compute(Collection $tax_areas)
    {
        if ($this->isUserClaimingExemption()) {
            return 0.00;
        }

        $this->tax_total = $this->payroll->withholdTax($this->getTaxableIncome($this->getAmountForTaxableIncome())  / $this->payroll->pay_periods) + $this->getAdditionalWithholding();

        return round($this->tax_total, 2);
    }

    public function getAmountForTaxableIncome()
    {
        $amount = $this->getAnnualWages();
        $amount -= $this->getStandardDeduction($amount);
        $amount -= $this->getExemptionAmount();

        return $amount > 0 ? $amount : 0.0;
    }

    public function getExemptionAmount()
    {
        return $this->tax_information->exemptions * self::EXEMPTION_AMOUNT;
    }

    public function getAnnualWages()
    {
        return $this->getAdjustedEarnings() * $this->payroll->pay_periods;
    }

    public function getTaxableIncome($amount)
    {
        return $this->getTaxAmountFromTaxBrackets($amount, self::TAX_BRACKET);
    }

    public function getStandardDeduction($amount)
    {
        if ($this->tax_information->filing_status === self::FILING_MARRIED) {
            if ($amount <= 21400) {
                return self::MARRIED_STANDARD_DEDUCTION_AMOUNT;
            } elseif ($amount > 21400 && $amount < 60750) {
                return self::MARRIED_STANDARD_DEDUCTION_AMOUNT - .2 * ($amount - 21400) ?? 0;
            } else {
                return 0.0;
            }
        } else {
            if ($amount <= 15200) {
                return self::SINGLE_STANDARD_DEDUCTION_AMOUNT;
            } elseif ($amount > 15200 && $amount < 62950) {
                return self::SINGLE_STANDARD_DEDUCTION_AMOUNT - .12 * ($amount - 15200) ?? 0;
            } else {
                return 0.0;
            }
        }
    }

    public function getTaxBrackets()
    {
        return;
    }
}
