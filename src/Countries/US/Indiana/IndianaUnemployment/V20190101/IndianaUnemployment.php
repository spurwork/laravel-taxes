<?php

namespace Appleton\Taxes\Countries\US\Indiana\IndianaUnemployment\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Indiana\IndianaUnemployment\IndianaUnemployment as BaseIndianaUnemployment;

class IndianaUnemployment extends BaseIndianaUnemployment
{
    public const FUTA_CREDIT = 0.054;
    public const WAGE_BASE = 9500;

    public const TAX_RATE = 0.025; // new employer rate

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.indiana.unemployment', static::TAX_RATE);
    }
}
