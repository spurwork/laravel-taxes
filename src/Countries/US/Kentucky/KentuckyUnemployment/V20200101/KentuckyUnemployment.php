<?php

namespace Appleton\Taxes\Countries\US\Kentucky\KentuckyUnemployment\V20200101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Kentucky\KentuckyUnemployment\KentuckyUnemployment as BaseKentuckyUnemployment;

class KentuckyUnemployment extends BaseKentuckyUnemployment
{
    public const FUTA_CREDIT = 0.054;
    public const WAGE_BASE = 10800;

    private const NEW_EMPLOYER_RATE = 0.027;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.kentucky.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
