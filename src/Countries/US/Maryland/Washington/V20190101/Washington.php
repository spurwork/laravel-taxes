<?php

namespace Appleton\Taxes\Countries\US\Maryland\Washington\V20190101;

use Appleton\Taxes\Countries\US\Maryland\Washington\Washington as BaseWashington;

class Washington extends BaseWashington
{
    public function getTaxRate()
    {
        return 0.028;
    }
}