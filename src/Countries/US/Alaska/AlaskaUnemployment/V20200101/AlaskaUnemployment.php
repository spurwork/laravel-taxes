<?php

namespace Appleton\Taxes\Countries\US\Alaska\AlaskaUnemployment\V20200101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Alaska\AlaskaUnemployment\AlaskaUnemployment as BaseAlaskaUnemployment;

class AlaskaUnemployment extends BaseAlaskaUnemployment
{
    public const FUTA_CREDIT = 0.054;
    public const TAX_RATE = 0.0132;
    public const WAGE_BASE = 41500;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.alaska.unemployment', static::TAX_RATE);
    }
}
