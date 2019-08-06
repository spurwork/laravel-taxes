<?php

namespace Appleton\Taxes\Countries\US\NewYork\Yonkers\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\NewYork\NewYorkIncome\NewYorkIncome;
use Appleton\Taxes\Countries\US\NewYork\NewYorkIncome\V20190101\NewYorkIncome as NewYorkIncome2019;
use Appleton\Taxes\Countries\US\NewYork\Yonkers\Yonkers as BaseYonkers;
use Appleton\Taxes\Models\Countries\US\NewYork\NewYorkIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

class Yonkers extends BaseYonkers
{
    const TAX_RATE = 0.1675;
    const NONRESIDENT_TAX_RATE = 0.005;

    const NONRESIDENT_MINIMUM_ANNUALIZED_WAGES = 3999.99;

    const NONRESIDENT_ANNUALIZED_EXCLUSIONS = [
        [3999.99, 10000, 3000],
        [10000, 10000, 2000],
        [20000, 10000, 1000],
        [30000, 10000, 0],
    ];

    public function __construct(NewYorkIncomeTaxInformation $tax_information,
                                Payroll $payroll, NewYorkIncome $new_york_income)
    {
        parent::__construct($tax_information, $payroll);
        $this->new_york_income = $new_york_income;
    }

    public function getNonResidentAdjustedEarnings()
    {
        $adjusted_earnings = $this->payroll->getEarnings() * $this->payroll->pay_periods;

        if ($adjusted_earnings <= static::NONRESIDENT_MINIMUM_ANNUALIZED_WAGES) {
            $adjusted_earnings = 0;
        } else {
            $adjusted_earnings -= $this->getNonResidentExclusionAmount($adjusted_earnings, static::NONRESIDENT_ANNUALIZED_EXCLUSIONS);
        }

        return $adjusted_earnings / $this->payroll->pay_periods;
    }

    public function getNonResidentExclusionAmount($amount, $table)
    {
        $bracket = end($table);
        foreach ($table as $row) {
            if ($row[0] <= $amount) {
                $bracket = $row;
            }
        }
        return $bracket[2];
    }

    public function getTaxBrackets()
    {
        return [[0, self::TAX_RATE, 0]];
    }

    public function compute(Collection $tax_areas)
    {
        $resident = $tax_areas->contains(function ($tax_area) {
            return $tax_area->homeGovernmentalUnitArea->id !== $tax_area->workGovernmentalUnitArea->id;
        });

        if ($resident) {
            $ny_tax_information = $this->tax_information->replicate();
            $ny_tax_information->ny_additional_withholding = 0;

            // todo: need a better way to instantiate this, TaxServiceProvider doesn't support parameters
            $ny_income = new NewYorkIncome2019($ny_tax_information, $this->payroll);
            $tax_amount = ($ny_income->compute($tax_areas) * static::TAX_RATE);

            $this->tax_total = $this->payroll->withholdTax($tax_amount) +
                $this->payroll->withholdTax($this->getAdditionalWithholding());

        } else {
            $tax_amount = $this->getNonResidentAdjustedEarnings() * static::NONRESIDENT_TAX_RATE;
            $this->tax_total = $this->payroll->withholdTax($tax_amount);
        }

        return round($this->tax_total, 2);
    }

    public function getAdditionalWithholding()
    {
        return max(min($this->payroll->getNetEarnings(), $this->tax_information->yonkers_additional_withholding), 0);
    }
}
