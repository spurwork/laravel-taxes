<?php

namespace Appleton\Taxes\Countries\US\Indiana\RipleyIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\RipleyIncome\RipleyIncome as BaseRipleyIncome;

class RipleyIncome extends BaseRipleyIncome
{
    public function getTaxRate(): float
    {
        return 0.0138;
    }
}