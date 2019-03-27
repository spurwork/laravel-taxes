<?php

namespace Appleton\Taxes\Countries\US\Maryland\Talbot\V20190101;

use Appleton\Taxes\Countries\US\Maryland\Talbot\Talbot as BaseTalbot;

class Talbot extends BaseTalbot
{
    public function getTaxRate()
    {
        return 0.024;
    }
}