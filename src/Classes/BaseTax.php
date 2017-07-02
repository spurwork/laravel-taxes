<?php

namespace Appleton\Taxes\Classes;

abstract class BaseTax
{
    public function __construct($earnings)
    {
        $this->earnings = $earnings;
    }

    public function compute()
    {
        return round($this->earnings * get_called_class()::TAX_RATE, 2);
    }

}
