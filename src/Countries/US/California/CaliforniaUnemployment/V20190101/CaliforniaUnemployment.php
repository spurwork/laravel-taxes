<?php

namespace Appleton\Taxes\Countries\US\California\CaliforniaUnemployment\V20190101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\California\CaliforniaUnemployment\CaliforniaUnemployment as BaseCaliforniaUnemployment;

class CaliforniaUnemployment extends BaseCaliforniaUnemployment
{
    public const FUTA_CREDIT = 0.054;
    public const WAGE_BASE = 7000;
    public const TAX_RATE = 0.034;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.california.unemployment', static::TAX_RATE);
    }
}
