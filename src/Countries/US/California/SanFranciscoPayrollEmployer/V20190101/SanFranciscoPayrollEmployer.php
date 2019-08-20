<?php

namespace Appleton\Taxes\Countries\US\California\SanFranciscoPayrollEmployer\V20190101;

use Appleton\Taxes\Countries\US\California\SanFranciscoPayrollEmployer\SanFranciscoPayrollEmployer as BaseSanFranciscoPayrollEmployer;

class SanFranciscoPayrollEmployer extends BaseSanFranciscoPayrollEmployer
{
    private const START_AMOUNT = 3000000;
    private const TAX_AMOUNT = .0038;

    public function getStartAmount(): int
    {
        return self::START_AMOUNT;
    }

    public function getTaxAmount(): float
    {
        return self::TAX_AMOUNT;
    }
}
