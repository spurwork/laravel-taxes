<?php

namespace Appleton\Taxes\Countries\US\Indiana\FultonIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\FultonIncome\FultonIncome as BaseFultonIncome;

class FultonIncome extends BaseFultonIncome
{
    public function getTaxRate(): float
    {
        return 0.0238;
    }
}