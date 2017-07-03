<?php

namespace Appleton\Taxes\Traits;

trait HasWageBase
{
    private function getBaseEarnings()
    {
        return ($this->ytd_earnings >= static::WAGE_BASE) ? 0 : static::WAGE_BASE - $this->ytd_earnings;
    }
}
