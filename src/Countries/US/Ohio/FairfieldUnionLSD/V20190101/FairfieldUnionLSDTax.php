<?php

namespace Appleton\Taxes\Countries\US\Ohio\FairfieldUnionLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\FairfieldUnionLSD\FairfieldUnionLSDTax as BaseFairfieldUnionLSDTax;

class FairfieldUnionLSDTax extends BaseFairfieldUnionLSDTax
{
    public const TAX_RATE = 0.02;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
