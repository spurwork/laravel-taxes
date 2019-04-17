<?php

namespace Appleton\Taxes\Countries\US\Maryland\Dorchester\V20190101;

use Appleton\Taxes\Countries\US\Maryland\Dorchester\Dorchester as BaseDorchester;

class Dorchester extends BaseDorchester
{
    public function getTaxRate()
    {
        return 0.0262;
    }
}