<?php

namespace Appleton\Taxes\Traits;

trait HasWageBase
{
    private function hasMetWageBase()
    {
        $this->ytdEarnings() >= self::WAGE_BASE;
    }

    private function getBaseEarnings()
    {
        return $this->hasMetWageBase() ? 0 : self::WAGE_BASE - $this->ytdEarnings();
    }

    private function getAdjustedEarnings()
    {
        return $this->earnings() < $this->getBaseEarnings() ? $this->earnings() : $this->getBaseEarnings();
    }
}
