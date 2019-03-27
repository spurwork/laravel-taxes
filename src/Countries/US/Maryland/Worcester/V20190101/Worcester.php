<?php

namespace Appleton\Taxes\Countries\US\Maryland\Worcester\V20190101;

use Appleton\Taxes\Countries\US\Maryland\Worcester\Worcester as BaseWorcester;

class Worcester extends BaseWorcester
{
    public function getTaxRate()
    {
        return 0.0175;
    }
}