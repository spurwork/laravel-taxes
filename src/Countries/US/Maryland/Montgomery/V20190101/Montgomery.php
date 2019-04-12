<?php

namespace Appleton\Taxes\Countries\US\Maryland\Montgomery\V20190101;

use Appleton\Taxes\Countries\US\Maryland\Montgomery\Montgomery as BaseMontgomery;

class Montgomery extends BaseMontgomery
{
    public function getTaxRate()
    {
        return 0.0320;
    }
}