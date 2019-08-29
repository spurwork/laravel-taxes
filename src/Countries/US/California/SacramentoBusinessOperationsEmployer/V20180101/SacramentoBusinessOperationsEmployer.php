<?php

namespace Appleton\Taxes\Countries\US\California\SacramentoBusinessOperationsEmployer\V20180101;

use Appleton\Taxes\Countries\US\California\SacramentoBusinessOperationsEmployer\SacramentoBusinessOperationsEmployer as BaseSacramentoBusinessOperationsEmployer;
use Illuminate\Support\Collection;

class SacramentoBusinessOperationsEmployer extends BaseSacramentoBusinessOperationsEmployer
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
