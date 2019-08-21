<?php

namespace Appleton\Taxes\Countries\US\SouthDakota\SouthDakotaUnemployment\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\SouthDakota\SouthDakotaUnemployment\SouthDakotaUnemployment as BaseSouthDakotaUnemployment;

class SouthDakotaUnemployment extends BaseSouthDakotaUnemployment
{
    public const FUTA_CREDIT = 0.06;
    public const TAX_RATE = 0.012;
    public const WAGE_BASE = 15000;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.south_dakota.unemployment', static::TAX_RATE);
    }
}
