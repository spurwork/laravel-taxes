<?php

namespace Appleton\Taxes\Tests\Unit\Classes\WorkerTaxes\Taxes;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseTax;
use Appleton\Taxes\Classes\WorkerTaxes\TaxScope;
use Appleton\Taxes\Classes\WorkerTaxes\TaxType;
use Illuminate\Database\Eloquent\Collection;

class FederalTax2 extends BaseTax
{
    public const SCOPE = TaxScope::WORKER;
    public const TYPE = TaxType::FEDERAL;
    public const WITHHELD = true;
    public const TAX_RATE = 0.1;

    public function compute(Collection $tax_areas)
    {
        return $this->payroll->getEarnings() * self::TAX_RATE;
    }
}
