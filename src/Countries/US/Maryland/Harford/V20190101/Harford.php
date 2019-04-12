<?php

namespace Appleton\Taxes\Countries\US\Maryland\Harford\V20190101;

use Appleton\Taxes\Countries\US\Maryland\Harford\Harford as BaseHarford;

class Harford extends BaseHarford
{
    public function getTaxRate()
    {
        return 0.0306;
    }
}