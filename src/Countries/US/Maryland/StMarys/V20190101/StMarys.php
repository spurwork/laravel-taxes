<?php

namespace Appleton\Taxes\Countries\US\Maryland\StMarys\V20190101;

use Appleton\Taxes\Countries\US\Maryland\StMarys\StMarys as BaseStMarys;

class StMarys extends BaseStMarys
{
    public function getTaxRate()
    {
        return 0.03;
    }
}