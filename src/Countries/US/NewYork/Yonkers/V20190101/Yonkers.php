<?php

namespace Appleton\Taxes\Countries\US\NewYork\Yonkers\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\NewYork\NewYorkIncome\NewYorkIncome;
use Appleton\Taxes\Countries\US\NewYork\Yonkers\Yonkers as BaseYonkers;

class Yonkers extends BaseYonkers
{
    const TAX_RATE = 0.1675;
    const NONRESIDENT_TAX_RATE = 0.005;
    const SUPPLEMENTAL_TAX_RATE = 0.0161135;

    public function __construct(Payroll $payroll, NewYorkIncome $new_york_income)
    {
        parent::__construct($payroll);
        $this->new_york_income = $new_york_income;
    }

    public function compute()
    {
        $this->tax_total = $this->new_york_income->getAmount() * static::TAX_RATE;
        return round($this->tax_total, 2);
    }
}
