<?php

namespace Appleton\Taxes\Countries\US\Ohio\FairbanksLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\FairbanksLSD\FairbanksLSDTax as BaseFairbanksLSDTax;

class FairbanksLSDTax extends BaseFairbanksLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
