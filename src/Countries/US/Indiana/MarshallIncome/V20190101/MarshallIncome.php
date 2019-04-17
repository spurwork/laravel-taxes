<?php

namespace Appleton\Taxes\Countries\US\Indiana\MarshallIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\MarshallIncome\MarshallIncome as BaseMarshallIncome;

class MarshallIncome extends BaseMarshallIncome
{
    public function getTaxRate(): float
    {
        return 0.0125;
    }
}