<?php

namespace Appleton\Taxes\Countries\US\California\SanFranciscoPayrollExpenseEmployer\V20180101;

use Appleton\Taxes\Countries\US\California\SanFranciscoPayrollExpenseEmployer\SanFranciscoPayrollExpenseEmployer as BaseSanFranciscoPayrollExpenseEmployer;
use Illuminate\Support\Collection;

class SanFranciscoPayrollExpenseEmployer extends BaseSanFranciscoPayrollExpenseEmployer
{
    public function compute(Collection $tax_areas): int
    {
        return 0;
    }

    public function getStartAmount(): int
    {
        return 0;
    }

    public function getTaxAmount(): float
    {
        return 0.0;
    }
}
