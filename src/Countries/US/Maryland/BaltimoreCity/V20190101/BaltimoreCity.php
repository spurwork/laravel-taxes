<?php

namespace Appleton\Taxes\Countries\US\Maryland\BaltimoreCity\V20190101;

use Appleton\Taxes\Countries\US\Maryland\BaltimoreCity\BaltimoreCity as BaseBaltimoreCity;

class BaltimoreCity extends BaseBaltimoreCity
{
    public function getTaxRate()
    {
        return 0.0320;
    }
}