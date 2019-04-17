<?php

namespace Appleton\Taxes\Countries\US\Indiana\VigoIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\VigoIncome\VigoIncome as BaseVigoIncome;

class VigoIncome extends BaseVigoIncome
{
    public function getTaxRate(): float
    {
        return 0.02;
    }
}