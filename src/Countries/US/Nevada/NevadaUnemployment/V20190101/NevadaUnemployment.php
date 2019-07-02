<?php

namespace Appleton\Taxes\Countries\US\Nevada\NevadaUnemployment\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Nevada\NevadaUnemployment\NevadaUnemployment as BaseNevadaUnemployment;

class NevadaUnemployment extends BaseNevadaUnemployment
{
    public const FUTA_CREDIT = 0.054;
    public const TAX_RATE = 0.03;
    public const WAGE_BASE = 31200;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.nevada.unemployment', static::TAX_RATE);
    }
}
