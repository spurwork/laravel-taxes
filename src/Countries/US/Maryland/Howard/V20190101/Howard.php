<?php

namespace Appleton\Taxes\Countries\US\Maryland\Howard\V20190101;

use Appleton\Taxes\Countries\US\Maryland\Howard\Howard as BaseHoward;

class Howard extends BaseHoward
{
    public function getTaxRate()
    {
        return 0.0320;
    }
}