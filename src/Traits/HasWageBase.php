<?php

namespace Appleton\Taxes\Traits;

trait HasWageBase
{
    public function getBaseEarnings()
    {
        return max(min(static::WAGE_BASE - $this->payroll->ytd_earnings, $this->payroll->getEarnings()), 0);
    }
}
