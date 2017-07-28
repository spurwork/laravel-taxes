<?php

namespace Appleton\Taxes\Traits;

trait HasWageBase
{
    public function getBaseEarnings()
    {
        return max(min($this->wage_base - $this->payroll->ytd_earnings, $this->payroll->earnings), 0);
    }
}
