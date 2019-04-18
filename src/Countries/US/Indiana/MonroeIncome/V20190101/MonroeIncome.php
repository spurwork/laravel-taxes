<?php

namespace Appleton\Taxes\Countries\US\Indiana\MonroeIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\MonroeIncome\MonroeIncome as BaseMonroeIncome;

class MonroeIncome extends BaseMonroeIncome
{
    public function getTaxRate(): float
    {
        return 0.01345;
    }
}