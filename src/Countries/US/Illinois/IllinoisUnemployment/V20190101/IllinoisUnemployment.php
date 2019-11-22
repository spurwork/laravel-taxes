<?php

namespace Appleton\Taxes\Countries\US\Illinois\IllinoisUnemployment\V20190101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Illinois\IllinoisUnemployment\IllinoisUnemployment as BaseIllinoisUnemployment;

class IllinoisUnemployment extends BaseIllinoisUnemployment
{
    public const FUTA_CREDIT = 0.054;
    public const WAGE_BASE = 12960;
    public const TAX_RATE = 0.03175; // new employer rate

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.illinois.unemployment', static::TAX_RATE);
    }
}
