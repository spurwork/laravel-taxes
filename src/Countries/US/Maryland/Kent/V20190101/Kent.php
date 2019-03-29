<?php

namespace Appleton\Taxes\Countries\US\Maryland\Kent\V20190101;

use Appleton\Taxes\Countries\US\Maryland\Kent\Kent as BaseKent;

class Kent extends BaseKent
{
    public function getTaxRate()
    {
        return 0.0285;
    }
}