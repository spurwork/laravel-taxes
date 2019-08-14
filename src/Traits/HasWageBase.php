<?php

namespace Appleton\Taxes\Traits;

trait HasWageBase
{
    public function getBaseEarnings($governmental_unit_area = null)
    {
        $wage_start = defined('static::WAGE_START') ? static::WAGE_START : 0;

        $collected_so_far = max($this->payroll->getYtdEarnings($governmental_unit_area) - $wage_start, 0);

        $left_to_collect = max(static::WAGE_BASE - $collected_so_far - $wage_start, 0);

        $how_much_to_collect = max($this->payroll->getEarnings() - $wage_start + $this->payroll->getYtdEarnings($governmental_unit_area), 0);

        return min(min($left_to_collect, $how_much_to_collect), $this->payroll->getEarnings());
    }
}
