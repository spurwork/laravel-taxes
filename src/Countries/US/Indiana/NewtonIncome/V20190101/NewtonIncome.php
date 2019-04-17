<?php

namespace Appleton\Taxes\Countries\US\Indiana\NewtonIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\NewtonIncome\NewtonIncome as BaseNewtonIncome;

class NewtonIncome extends BaseNewtonIncome
{
    public function getTaxRate(): float
    {
        return 0.01;
    }
}