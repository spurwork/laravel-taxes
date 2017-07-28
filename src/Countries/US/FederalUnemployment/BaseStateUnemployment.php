<?php

namespace Appleton\Taxes\Countries\US\FederalUnemployment;

use Appleton\Taxes\Classes\BaseTax;

class BaseStateUnemployment extends BaseTax implements StateUnemployment
{
    public function getTaxCredit() {
        return defined('static::FUTA_CREDIT') ? static::FUTA_CREDIT : 0;
    }
}
