<?php

namespace Appleton\Taxes\Countries\US\Indiana\TippecanoeIncome\V20200101;

use Appleton\Taxes\Countries\US\Indiana\TippecanoeIncome\TippecanoeIncome as BaseTippecanoeIncome;

class TippecanoeIncome extends BaseTippecanoeIncome
{
    public function getTaxRate(): float
    {
        return 0.0128;
    }
}
