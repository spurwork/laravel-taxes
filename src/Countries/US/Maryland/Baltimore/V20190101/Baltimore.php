<?php

namespace Appleton\Taxes\Countries\US\Maryland\Baltimore\V20190101;

use Appleton\Taxes\Countries\US\Maryland\Baltimore\Baltimore as BaseBaltimore;

class Baltimore extends BaseBaltimore
{
    public function getTaxRate()
    {
        return 0.0283;
    }
}