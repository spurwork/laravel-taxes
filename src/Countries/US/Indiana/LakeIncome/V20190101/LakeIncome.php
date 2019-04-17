<?php

namespace Appleton\Taxes\Countries\US\Indiana\LakeIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\LakeIncome\LakeIncome as BaseLakeIncome;

class LakeIncome extends BaseLakeIncome
{
    public function getTaxRate(): float
    {
        return 0.015;
    }
}