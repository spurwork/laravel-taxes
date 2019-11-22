<?php

namespace Appleton\Taxes\Countries\US\Ohio\KalidaLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\KalidaLSD\KalidaLSDTax as BaseKalidaLSDTax;

class KalidaLSDTax extends BaseKalidaLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
