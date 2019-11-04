<?php

namespace Appleton\Taxes\Countries\US\Tennessee\TennesseeUnemployment\V20190101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Tennessee\TennesseeUnemployment\TennesseeUnemployment as BaseTennesseeUnemployment;

class TennesseeUnemployment extends BaseTennesseeUnemployment
{
    public const FUTA_CREDIT = 0.054;
    public const WAGE_BASE = 7000;

    private const RATE = 0.027;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.tennessee.unemployment', static::RATE);
    }
}
