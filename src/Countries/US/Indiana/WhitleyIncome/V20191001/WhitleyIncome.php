<?php

namespace Appleton\Taxes\Countries\US\Indiana\WhitleyIncome\V20191001;

use Appleton\Taxes\Countries\US\Indiana\WhitleyIncome\WhitleyIncome as BaseWhitleyIncome;

class WhitleyIncome extends BaseWhitleyIncome
{
    public function getTaxRate(): float
    {
        return 0.016829;
    }
}
