<?php

namespace Appleton\Taxes\Countries\US\Maryland\Garrett\V20190101;

use Appleton\Taxes\Countries\US\Maryland\Garrett\Garrett as BaseGarrett;

class Garrett extends BaseGarrett
{
    public function getTaxRate()
    {
        return 0.0265;
    }
}