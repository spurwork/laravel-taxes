<?php

namespace Appleton\Taxes\Traits;

trait HasWageBase
{
    public function getBaseEarnings($governmental_unit_area = null)
    {
        return max(min(static::WAGE_BASE - $this->payroll->getYtdEarnings($governmental_unit_area), $this->payroll->getEarnings()), 0);
    }
}
