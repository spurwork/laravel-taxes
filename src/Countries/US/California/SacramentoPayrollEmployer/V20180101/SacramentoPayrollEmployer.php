<?php

namespace Appleton\Taxes\Countries\US\California\SacramentoPayrollEmployer\V20180101;

use Appleton\Taxes\Countries\US\California\SacramentoPayrollEmployer\SacramentoPayrollEmployer as BaseSacramentoPayrollEmployer;
use Illuminate\Support\Collection;

class SacramentoPayrollEmployer extends BaseSacramentoPayrollEmployer
{
    public function compute(Collection $tax_areas): int
    {
        return 0;
    }

    public function getInitialTax(): int
    {
        return 0;
    }

    public function getMaxLiability(): int
    {
        return 0;
    }

    public function getStartAmount(): int
    {
        return 0;
    }

    public function getTaxAmount(): float
    {
        return 0;
    }
}
