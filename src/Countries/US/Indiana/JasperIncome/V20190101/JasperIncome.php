<?php

namespace Appleton\Taxes\Countries\US\Indiana\JasperIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\JasperIncome\JasperIncome as BaseJasperIncome;

class JasperIncome extends BaseJasperIncome
{
    public function getTaxRate(): float
    {
        return 0.02864;
    }
}