<?php

namespace Appleton\Taxes\Countries\US\Maryland\Cecil\V20190101;

use Appleton\Taxes\Countries\US\Maryland\Cecil\Cecil as BaseCecil;

class Cecil extends BaseCecil
{
    public function getTaxRate()
    {
        return 0.03;
    }
}