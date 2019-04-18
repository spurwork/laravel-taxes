<?php

namespace Appleton\Taxes\Countries\US\Indiana\MiamiIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\MiamiIncome\MiamiIncome as BaseMiamiIncome;

class MiamiIncome extends BaseMiamiIncome
{
    public function getTaxRate(): float
    {
        return 0.0254;
    }
}