<?php

namespace Appleton\Taxes\Countries\US\Maryland\Caroline\V20190101;

use Appleton\Taxes\Countries\US\Maryland\Caroline\Caroline as BaseCaroline;

class Caroline extends BaseCaroline
{
    public function getTaxRate()
    {
        return 0.032;
    }
}