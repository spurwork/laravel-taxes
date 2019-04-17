<?php

namespace Appleton\Taxes\Countries\US\Indiana\BartholomewIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\BartholomewIncome\BartholomewIncome as BaseBartholomewIncome;

class BartholomewIncome extends BaseBartholomewIncome
{
    public function getTaxRate(): float
    {
        return 0.0175;
    }
}