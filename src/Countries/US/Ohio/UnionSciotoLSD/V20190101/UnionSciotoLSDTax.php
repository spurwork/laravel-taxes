<?php

namespace Appleton\Taxes\Countries\US\Ohio\UnionSciotoLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\UnionSciotoLSD\UnionSciotoLSDTax as BaseUnionSciotoLSDTax;

class UnionSciotoLSDTax extends BaseUnionSciotoLSDTax
{
    public const TAX_RATE = 0.005;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
