<?php

namespace Appleton\Taxes\Countries\US\California\SanFranciscoPayrollEmployer\V20180101;

use Appleton\Taxes\Countries\US\California\SanFranciscoPayrollEmployer\SanFranciscoPayrollEmployer as BaseSanFranciscoPayrollEmployer;
use Illuminate\Support\Collection;

class SanFranciscoPayrollEmployer extends BaseSanFranciscoPayrollEmployer
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
