<?php

namespace Appleton\Taxes\Countries\US\Indiana\JacksonIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\JacksonIncome\JacksonIncome as BaseJacksonIncome;

class JacksonIncome extends BaseJacksonIncome
{
    public function getTaxRate(): float
    {
        return 0.021;
    }
}