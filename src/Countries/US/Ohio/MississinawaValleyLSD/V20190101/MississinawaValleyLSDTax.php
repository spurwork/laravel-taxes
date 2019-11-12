<?php

namespace Appleton\Taxes\Countries\US\Ohio\MississinawaValleyLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\MississinawaValleyLSD\MississinawaValleyLSDTax as BaseMississinawaValleyLSDTax;

class MississinawaValleyLSDTax extends BaseMississinawaValleyLSDTax
{
    public const TAX_RATE = 0.0175;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
