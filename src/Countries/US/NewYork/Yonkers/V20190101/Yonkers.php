<?php

namespace Appleton\Taxes\Countries\US\NewYork\Yonkers\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\NewYork\NewYorkIncome\NewYorkIncome;
use Appleton\Taxes\Countries\US\NewYork\Yonkers\Yonkers as BaseYonkers;
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

    public function __construct(Payroll $payroll, NewYorkIncome $new_york_income)
    {
        $this->payroll = $payroll;
        $this->new_york_income = $new_york_income;
    }

    public function getAdjustedEarnings()
    {
        $adjusted_earnings = $this->payroll->earnings * $this->payroll->pay_periods;

        if ($adjusted_earnings <= static::NONRESIDENT_MINIMUM_ANNUALIZED_WAGES) {
            $adjusted_earnings = 0;
        } else {
            $adjusted_earnings -= $this->getExclusionAmount($adjusted_earnings, static::NONRESIDENT_ANNUALIZED_EXCLUSIONS);
        }

        return $adjusted_earnings / $this->payroll->pay_periods;
    }

    public function getExclusionAmount($amount, $table)
    {
        $bracket = end($table);
        foreach ($table as $row) {
            if ($row[0] <= $amount) {
                $bracket = $row;
            }
        }
        return $bracket[2];
    }

    public function compute(Collection $tax_areas)
    {
        $resident = $tax_areas->contains(function($tax_area) {
            return $tax_area->homeGovernmentalUnitArea->name === 'Yonkers, NY' && $tax_area->workGovernmentalUnitArea->name === 'New York';
        });

        if ($resident) {
            $this->tax_total = $this->new_york_income->getAmount() * static::TAX_RATE;
        } else {
            $this->tax_total = $this->getAdjustedEarnings() * static::NONRESIDENT_TAX_RATE;
        }

        return round($this->tax_total, 2);
    }
}
