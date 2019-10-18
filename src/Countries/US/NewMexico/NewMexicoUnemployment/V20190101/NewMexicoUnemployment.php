<?php

namespace Appleton\Taxes\Countries\US\NewMexico\NewMexicoUnemployment\V20190101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\NewMexico\NewMexicoUnemployment\NewMexicoUnemployment as BaseNewMexicoUnemployment;

class NewMexicoUnemployment extends BaseNewMexicoUnemployment
{
    public const FUTA_CREDIT = 0.054;

    public const NEW_EMPLOYER_RATE = 0.01;

    public const WAGE_BASE = 24800;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.new_mexico.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
