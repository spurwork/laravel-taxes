<?php

namespace Appleton\Taxes\Classes;

abstract class BaseStateUnemploymentTax extends BaseTax
{
    public static function getUnemploymentTaxCredit()
    {
        return get_called_class()::FUTA_CREDIT;
    }
}
