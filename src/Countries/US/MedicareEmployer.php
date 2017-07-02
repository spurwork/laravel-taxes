<?php

namespace Appleton\Taxes\Countries\US;

use Appleton\Taxes\Classes\BaseTax;

class MedicareEmployer extends Medicare
{
    const TYPE = 'federal';
    const WITHHELD = false;

    public function compute()
    {
        return round($this->earnings * self::TAX_RATE, 2);
    }
}
