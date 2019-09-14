<?php

namespace Appleton\Taxes\Countries\US\RhodeIsland\RhodeIslandUnemployment\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\RhodeIsland\RhodeIslandUnemployment\RhodeIslandUnemployment as BaseRhodeIslandUnemployment;

class RhodeIslandUnemployment extends BaseRhodeIslandUnemployment
{
    const FUTA_CREDIT = 0.06;
    const NEW_EMPLOYER_RATE = 0.0117;
    const WAGE_BASE = 23600;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.rhode_island.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
