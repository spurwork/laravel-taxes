<?php

namespace Appleton\Taxes\Tests\Unit\Classes\WorkerTaxes\Taxes;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateUnemployment;
use Appleton\Taxes\Classes\WorkerTaxes\TaxScope;
use Appleton\Taxes\Classes\WorkerTaxes\TaxType;
use Illuminate\Database\Eloquent\Collection;

class StateUnemploymentTax1 extends BaseStateUnemployment
{
    public const SCOPE = TaxScope::WORKER;
    public const TYPE = TaxType::STATE;
    public const WITHHELD = false;
    public const TAX_RATE = 0.1;

    public function compute(Collection $tax_areas)
    {
        $total_earnings = $this->payroll->getEarnings() + $this->payroll->getYtdEarnings();
        return $total_earnings * self::TAX_RATE;
    }
}
