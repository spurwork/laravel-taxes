<?php

namespace Appleton\Taxes\Countries\US\Indiana\WhiteIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\WhiteIncome\WhiteIncome as BaseWhiteIncome;

class WhiteIncome extends BaseWhiteIncome
{
    public function getTaxRate(): float
    {
        return 0.0232;
    }
}