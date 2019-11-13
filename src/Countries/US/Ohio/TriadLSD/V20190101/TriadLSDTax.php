<?php

namespace Appleton\Taxes\Countries\US\Ohio\TriadLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\TriadLSD\TriadLSDTax as BaseTriadLSDTax;

class TriadLSDTax extends BaseTriadLSDTax
{
    public const TAX_RATE = 0.015;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
