<?php

namespace Appleton\Taxes\Tests\Unit\Classes\WorkerTaxes\Taxes;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseState;
use Appleton\Taxes\Classes\WorkerTaxes\TaxScope;
use Appleton\Taxes\Classes\WorkerTaxes\TaxType;
use Illuminate\Database\Eloquent\Collection;

class StateTax2 extends BaseState
{
    public const SCOPE = TaxScope::WORKER;
    public const TYPE = TaxType::STATE;
    public const WITHHELD = true;
    public const TAX_RATE = 0.1;

    public function compute(Collection $tax_areas)
    {
        return $this->payroll->getEarnings() * self::TAX_RATE;
    }
}
