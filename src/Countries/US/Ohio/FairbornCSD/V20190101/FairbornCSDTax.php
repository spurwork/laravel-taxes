<?php

namespace Appleton\Taxes\Countries\US\Ohio\FairbornCSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\FairbornCSD\FairbornCSDTax as BaseFairbornCSDTax;

class FairbornCSDTax extends BaseFairbornCSDTax
{
    public const TAX_RATE = 0.005;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
