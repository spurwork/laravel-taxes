<?php

namespace Appleton\Taxes\Countries\US\Ohio\ChippewaLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\ChippewaLSD\ChippewaLSDTax as BaseChippewaLSDTax;

class ChippewaLSDTax extends BaseChippewaLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
