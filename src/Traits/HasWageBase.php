<?php

namespace Appleton\Taxes\Traits;

trait HasWageBase
{
    private function getBaseEarnings()
    {
        return ($this->ytd_earnings >= self::WAGE_BASE) ? 0 : self::WAGE_BASE - $this->ytd_earnings;
    }
}
