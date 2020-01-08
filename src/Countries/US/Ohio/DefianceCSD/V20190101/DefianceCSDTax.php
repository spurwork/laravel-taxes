<?php

namespace Appleton\Taxes\Countries\US\Ohio\DefianceCSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\DefianceCSD\DefianceCSDTax as BaseDefianceCSDTax;

class DefianceCSDTax extends BaseDefianceCSDTax
{
    public const TAX_RATE = 0.005;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
