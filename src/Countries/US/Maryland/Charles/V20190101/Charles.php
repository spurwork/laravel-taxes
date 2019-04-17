<?php

namespace Appleton\Taxes\Countries\US\Maryland\Charles\V20190101;

use Appleton\Taxes\Countries\US\Maryland\Charles\Charles as BaseCharles;

class Charles extends BaseCharles
{
    public function getTaxRate()
    {
        return 0.0303;
    }
}