<?php

namespace Appleton\Taxes\Countries\US\Illinois\IllinoisUnemployment\V20200101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Illinois\IllinoisUnemployment\IllinoisUnemployment as BaseIllinoisUnemployment;

class IllinoisUnemployment extends BaseIllinoisUnemployment
{
    public const FUTA_CREDIT = 0.054;
    public const WAGE_BASE = 12740;
    public const TAX_RATE = 0.03125;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.illinois.unemployment', static::TAX_RATE);
    }
}
