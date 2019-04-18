<?php

namespace Appleton\Taxes\Countries\US\Indiana\WabashIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\WabashIncome\WabashIncome as BaseWabashIncome;

class WabashIncome extends BaseWabashIncome
{
    public function getTaxRate(): float
    {
        return 0.029;
    }
}