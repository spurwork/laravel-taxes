<?php

namespace Appleton\Taxes\Countries\US\Arkansas\ArkansasIncome\V20190101;

use Appleton\Taxes\Countries\US\Arkansas\ArkansasIncome\ArkansasIncome as BaseArkansasIncome;
use Illuminate\Database\Eloquent\Collection;

class ArkansasIncome extends BaseArkansasIncome
{
    public const SUPPLEMENTAL_TAX_RATE = 0.069;

    private const STANDARD_DEDUCTION = 2200;
    private const EXEMPTION_AMOUNT = 26;

    private const BRACKETS = [
        [0, 0.00, 0],
        [4300, 0.02, 91.98],
        [9100, 0.03, 182.97],
        [13700, 0.034, 237.77],
        [22600, 0.05, 421.46],
        [37900, 0.059, 762.55],
        [80801, 0.066, 1243.4],
        [81801, 0.066, 1143.4],
        [82801, 0.066, 1043.4],
        [84101, 0.066, 943.4],
        [85201, 0.066, 843.4],
        [86201, 0.066, 803.4],
    ];

    private const ARKANSAS = 'Arkansas';
    private const TEXARKANA_AR = 'Texarkana, AR';
    private const TEXARKANA_TX = 'Texarkana, TX';

    public function compute(Collection $tax_areas)
    {
        if ($this->isUserClaimingExemption()) {
            return 0.00;
        }

        $annual_gross = $this->payroll->getEarnings() * $this->payroll->pay_periods;

        if ($this->payroll->livesInArea(self::ARKANSAS)) {
            if ($this->payroll->livesInArea(self::TEXARKANA_AR)) {
                if ($this->tax_information->ar_tx_exempt) {
                    return $this->payroll->withholdTax(0.0);
                }
            } elseif (!$this->payroll->hasWorkInArea(self::ARKANSAS)) {
                return $this->payroll->withholdTax(0.0);
            }
        } elseif ($this->payroll->livesInArea(self::TEXARKANA_TX)) {
            $annual_gross -= $this->payroll->getEarningsForArea(self::TEXARKANA_AR) * $this->payroll->pay_periods;
        }

        $net_taxable_income = $this->get50MidRange($annual_gross - self::STANDARD_DEDUCTION);

        $annual_gross_tax = $this->getTaxAmountFromTaxBrackets($net_taxable_income, $this->getTaxBrackets());
        $annual_personal_tax_credits = $this->tax_information->exemptions * self::EXEMPTION_AMOUNT;

        $annual_net_tax = max($annual_gross_tax - $annual_personal_tax_credits, 0);
        $withholding_amount = $annual_net_tax / $this->payroll->pay_periods;

        $this->tax_total = $this->payroll->withholdTax($withholding_amount) +
            $this->payroll->withholdTax($this->getSupplementalIncomeTax()) +
            $this->payroll->withholdTax($this->getAdditionalWithholding());

        return round(floor($this->tax_total * 100) / 100, 2);
    }

    public function getTaxBrackets()
    {
        return self::BRACKETS;
    }

    public function getTaxAmountFromTaxBrackets($amount, $table)
    {
        $bracket = $this->getTaxBracket($amount, $table);
        $tax_amount = isset($bracket) ? $amount * $bracket[1] - $bracket[2] : 0;

        return $tax_amount > 0 ? $tax_amount : 0;
    }

    private function get50MidRange(int $amount): int
    {
        if ($amount >= 87000) {
            return $amount;
        }

        return (floor($amount / 100) * 100) + 50;
    }
}
