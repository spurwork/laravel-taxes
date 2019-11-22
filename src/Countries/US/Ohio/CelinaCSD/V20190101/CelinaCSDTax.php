<?php

namespace Appleton\Taxes\Countries\US\Ohio\CelinaCSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\CelinaCSD\CelinaCSDTax as BaseCelinaCSDTax;

class CelinaCSDTax extends BaseCelinaCSDTax
{
    public const TAX_RATE = 0.0075;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
