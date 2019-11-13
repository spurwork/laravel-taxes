<?php

namespace Appleton\Taxes\Countries\US\Ohio\PandoraGilboaLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\PandoraGilboaLSD\PandoraGilboaLSDTax as BasePandoraGilboaLSDTax;

class PandoraGilboaLSDTax extends BasePandoraGilboaLSDTax
{
    public const TAX_RATE = 0.0175;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
