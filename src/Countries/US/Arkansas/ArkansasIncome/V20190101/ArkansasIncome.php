<?php

namespace Appleton\Taxes\Countries\US\Arkansas\ArkansasIncome\V20190101;

use Appleton\Taxes\Countries\US\Arkansas\ArkansasIncome\ArkansasIncome as BaseArkansasIncome;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ArkansasIncome extends BaseArkansasIncome
{
    public const SUPPLEMENTAL_TAX_RATE = 0.069;

    private const STANDARD_DEDUCTION = 2200;
    private const EXEMPTION_AMOUNT = 26;

    private const BRACKETS = [
        [0, 0.009, 0],
        [4300, 0.024, 64.49],
        [8400, 0.034, 148.48],
        [12600, 0.044, 274.47],
        [21000, 0.059, 589.45],
        [35100, 0.069, 940.44],
    ];

    private const TEXARKANA_AR = 'Texarkana, AR';
    private const TEXARKANA_TX = 'Texarkana, TX';

    public function compute(Collection $tax_areas)
    {
        if ($this->tax_information->ar_tx_exempt && $tax_areas->contains(function ($tax_area) {
            return $tax_area->home_governmental_unit_area_id === DB::table('governmental_unit_areas')->where('name', self::TEXARKANA_AR)->first()->id;
        })) {
            return 0.00;
        }

        if ($tax_areas->contains(function ($tax_area) {
            return $tax_area->home_governmental_unit_area_id == DB::table('governmental_unit_areas')->where('name', self::TEXARKANA_TX)->first()->id;
        })) {
            return 0.00;
        }

        if ($this->isUserClaimingExemption()) {
            return 0.00;
        }

        $annual_gross = $this->payroll->getEarnings() * $this->payroll->pay_periods;
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
        if ($amount >= 50000) {
            return $amount;
        }

        return (floor($amount / 100) * 100) + 50;
    }
}
