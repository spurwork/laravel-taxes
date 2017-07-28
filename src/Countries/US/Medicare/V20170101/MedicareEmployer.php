<?php

namespace Appleton\Taxes\Countries\US\Medicare\V20170101;

use Appleton\Taxes\Classes\BaseTax;

class MedicareEmployer extends Medicare
{
    const WITHHELD = false;

    public function compute()
    {
        return round($this->payroll->earnings * static::TAX_RATE, 2);
    }
}
