<?php

namespace Appleton\Taxes\Countries\US\Indiana\VermillionIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\VermillionIncome\VermillionIncome as BaseVermillionIncome;

class VermillionIncome extends BaseVermillionIncome
{
    public function getTaxRate(): float
    {
        return 0.015;
    }
}