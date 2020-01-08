<?php

namespace Appleton\Taxes\Countries\US\Arkansas\ArkansasUnemployment\V20200101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Arkansas\ArkansasUnemployment\ArkansasUnemployment as BaseArkansasUnemployment;

class ArkansasUnemployment extends BaseArkansasUnemployment
{
    public const NEW_EMPLOYER_RATE = 0.032;
    public const WAGE_BASE = 7000;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.arkansas.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
