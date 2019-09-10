<?php

namespace Appleton\Taxes\Countries\US\Nevada\NevadaGrossPayrollEmployer\V20180101;

use Appleton\Taxes\Countries\US\Nevada\NevadaGrossPayrollEmployer\NevadaGrossPayrollEmployer as BaseNevadaGrossPayrollEmployer;

class NevadaGrossPayrollEmployer extends BaseNevadaGrossPayrollEmployer
{
    protected function getStartAmount(): int
    {
        return 0;
    }

    protected function getTaxAmount(): float
    {
        return 0.0;
    }
}
