<?php

namespace Appleton\Taxes\Traits;

trait HasWageBase
{
    public function getBaseEarnings()
    {
        return max(min($this->wage_base - $this->ytd_earnings, $this->earnings), 0);
    }
}
