<?php

namespace Appleton\Taxes\Countries\US\Virginia\VirginiaUnemployment\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Virginia\VirginiaUnemployment\VirginiaUnemployment as BaseVirginiaUnemployment;

class VirginiaUnemployment extends BaseVirginiaUnemployment
{
    public const FUTA_CREDIT = 0.054;
    public const WAGE_BASE = 8000;
    public const TAX_RATE = 0.0251; // new employer rate

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.virginia.unemployment', static::TAX_RATE);
    }
}