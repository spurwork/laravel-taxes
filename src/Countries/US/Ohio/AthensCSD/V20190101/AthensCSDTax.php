<?php

namespace Appleton\Taxes\Countries\US\Ohio\AthensCSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\AthensCSD\AthensCSDTax as BaseAthensCSDTax;

class AthensCSDTax extends BaseAthensCSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
