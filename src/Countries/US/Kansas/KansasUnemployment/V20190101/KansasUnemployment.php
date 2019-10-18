<?php

namespace Appleton\Taxes\Countries\US\Kansas\KansasUnemployment\V20190101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Kansas\KansasUnemployment\KansasUnemployment as BaseKansasUnemployment;

class KansasUnemployment extends BaseKansasUnemployment
{
    public const FUTA_CREDIT = 0.054;
    public const WAGE_BASE = 14000;

    private const NEW_EMPLOYER_RATE = 0.027;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.kansas.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
