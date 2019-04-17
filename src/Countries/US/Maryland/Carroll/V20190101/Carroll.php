<?php

namespace Appleton\Taxes\Countries\US\Maryland\Carroll\V20190101;

use Appleton\Taxes\Countries\US\Maryland\Carroll\Carroll as BaseCarroll;

class Carroll extends BaseCarroll
{
    public function getTaxRate()
    {
        return 0.0303;
    }
}