<?php

namespace Appleton\Taxes\Countries\US\Maryland\Allegany\V20190101;

use Appleton\Taxes\Countries\US\Maryland\Allegany\Allegany as BaseAllegany;

class Allegany extends BaseAllegany
{
    public function getTaxRate()
    {
        return 0.0305;
    }
}