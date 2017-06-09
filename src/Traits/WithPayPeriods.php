<?php

namespace Appleton\Taxes\Traits;

trait WithPayPeriods
{
    private $payPeriods;

    private function payPeriods()
    {
        return $this->payPeriods;
    }

    public function withPayPeriods($payPeriods)
    {
        $this->payPeriods = $payPeriods;
        return $this;
    }
}
