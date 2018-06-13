<?php

namespace Appleton\Taxes\Classes;

use Appleton\Taxes\Contracts\US\FederalUnemployment\StateUnemployment;
use Appleton\Taxes\Models\TaxInformation;
use Exception;

abstract class BaseStateUnemployment extends BaseTax implements StateUnemployment
{
    public function getTaxCredit() {
        return defined('static::FUTA_CREDIT') ? static::FUTA_CREDIT : 0;
    }
}
