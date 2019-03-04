<?php

namespace Appleton\Taxes\Countries\US\Medicare\V20170101;

class MedicareEmployer extends Medicare
{
    const WITHHELD = false;

    public function compute()
    {
        return round($this->payroll->getEarnings() * static::TAX_RATE, 2);
    }
}
