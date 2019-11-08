<?php

namespace Appleton\Taxes\Countries\US\Ohio\TalawandaCSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\TalawandaCSD\TalawandaCSDTax as BaseTalawandaCSDTax;

class TalawandaCSDTax extends BaseTalawandaCSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
