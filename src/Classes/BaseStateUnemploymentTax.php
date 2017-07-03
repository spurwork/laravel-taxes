<?php

namespace Appleton\Taxes\Classes;

class BaseStateUnemploymentTax extends BaseTax
{
    public static function getUnemploymentTaxCredit()
    {
        return defined('static::FUTA_CREDIT') ? static::FUTA_CREDIT : 0;
    }
}
