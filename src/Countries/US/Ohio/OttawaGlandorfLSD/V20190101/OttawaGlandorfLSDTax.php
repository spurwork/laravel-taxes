<?php

namespace Appleton\Taxes\Countries\US\Ohio\OttawaGlandorfLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\OttawaGlandorfLSD\OttawaGlandorfLSDTax as BaseOttawaGlandorfLSDTax;

class OttawaGlandorfLSDTax extends BaseOttawaGlandorfLSDTax
{
    public const TAX_RATE = 0.005;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
