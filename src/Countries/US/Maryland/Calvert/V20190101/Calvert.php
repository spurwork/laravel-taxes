<?php

namespace Appleton\Taxes\Countries\US\Maryland\Calvert\V20190101;

use Appleton\Taxes\Countries\US\Maryland\Calvert\Calvert as BaseCalvert;

class Calvert extends BaseCalvert
{
    public function getTaxRate()
    {
        return 0.03;
    }
}