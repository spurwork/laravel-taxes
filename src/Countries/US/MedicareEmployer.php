<?php

namespace Appleton\Taxes\Countries\US;

use Appleton\Taxes\Classes\BaseTax;

class MedicareEmployer extends Medicare
{
    public function compute()
    {
        return round($this->earnings() * self::TAX_RATE, 2);
    }
}
