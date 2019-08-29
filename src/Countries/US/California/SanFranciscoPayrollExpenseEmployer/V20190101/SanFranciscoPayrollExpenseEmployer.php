<?php

namespace Appleton\Taxes\Countries\US\California\SanFranciscoPayrollExpenseEmployer\V20190101;

use Appleton\Taxes\Countries\US\California\SanFranciscoPayrollExpenseEmployer\SanFranciscoPayrollExpenseEmployer as BaseSanFranciscoPayrollExpenseEmployer;

class SanFranciscoPayrollExpenseEmployer extends BaseSanFranciscoPayrollExpenseEmployer
{
    private const START_AMOUNT = 30000000;
    private const TAX_AMOUNT = 0.0038;

    public function getStartAmount(): int
    {
        return self::START_AMOUNT;
    }

    public function getTaxAmount(): float
    {
        return self::TAX_AMOUNT;
    }
}
