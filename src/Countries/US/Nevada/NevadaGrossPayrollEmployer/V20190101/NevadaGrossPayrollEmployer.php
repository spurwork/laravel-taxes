<?php

namespace Appleton\Taxes\Countries\US\Nevada\NevadaGrossPayrollEmployer\V20190101;

use Appleton\Taxes\Countries\US\Nevada\NevadaGrossPayrollEmployer\NevadaGrossPayrollEmployer as BaseNevadaGrossPayrollEmployer;

class NevadaGrossPayrollEmployer extends BaseNevadaGrossPayrollEmployer
{
    private const START_AMOUNT = 5000000;
    private const TAX_AMOUNT = 0.01475;

    protected function getStartAmount(): int
    {
        return self::START_AMOUNT;
    }

    protected function getTaxAmount(): float
    {
        return self::TAX_AMOUNT;
    }
}
