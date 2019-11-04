<?php

namespace Appleton\Taxes\Countries\US\WestVirginia\WestVirginiaUnemployment\V20190101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\WestVirginia\WestVirginiaUnemployment\WestVirginiaUnemployment as BaseWestVirginiaUnemployment;

class WestVirginiaUnemployment extends BaseWestVirginiaUnemployment
{
    public const FUTA_CREDIT = 0.054;
    public const WAGE_BASE = 12000;
    public const TAX_RATE = 0.027;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.west_virginia.unemployment', static::TAX_RATE);
    }
}
