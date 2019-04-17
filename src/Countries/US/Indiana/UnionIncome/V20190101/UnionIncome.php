<?php

namespace Appleton\Taxes\Countries\US\Indiana\UnionIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\UnionIncome\UnionIncome as BaseUnionIncome;

class UnionIncome extends BaseUnionIncome
{
    public function getTaxRate(): float
    {
        return 0.0175;
    }
}