<?php

namespace Appleton\Taxes\Countries\US\Maryland\Somerset\V20190101;

use Appleton\Taxes\Countries\US\Maryland\Somerset\Somerset as BaseSomerset;

class Somerset extends BaseSomerset
{
    public function getTaxRate()
    {
        return 0.0320;
    }
}