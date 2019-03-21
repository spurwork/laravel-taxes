<?php

namespace Appleton\Taxes\Countries\US\Kentucky\KentuckyUnemployment\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Kentucky\KentuckyUnemployment\KentuckyUnemployment as BaseKentuckyUnemployment;

class KentuckyUnemployment extends BaseKentuckyUnemployment
{
    public const FUTA_CREDIT = 0.054;

    private const NEW_EMPLOYER_RATE = 0.027;

    protected const WAGE_BASE = 10500;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.kentucky.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
