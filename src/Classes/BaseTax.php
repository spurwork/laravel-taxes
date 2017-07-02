<?php

namespace Appleton\Taxes\Classes;

class BaseTax
{
    public function __construct($earnings)
    {
        $this->earnings = $earnings;
    }

    public static function getType()
    {
        return get_called_class()::TYPE;
    }

    public static function getWithheld()
    {
        return get_called_class()::WITHHELD;
    }

    public function compute()
    {
        return round($this->earnings * get_called_class()::TAX_RATE, 2);
    }
}
