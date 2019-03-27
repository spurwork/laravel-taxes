<?php

namespace Appleton\Taxes\Countries\US\Maryland\Frederick\V20190101;

use Appleton\Taxes\Countries\US\Maryland\Frederick\Frederick as BaseFredrick;

class Frederick extends BaseFredrick
{
    public function getTaxRate()
    {
        return 0.0296;
    }
}