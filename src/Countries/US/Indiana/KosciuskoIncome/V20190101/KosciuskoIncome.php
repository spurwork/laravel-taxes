<?php

namespace Appleton\Taxes\Countries\US\Indiana\KosciuskoIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\KosciuskoIncome\KosciuskoIncome as BaseKosciuskoIncome;

class KosciuskoIncome extends BaseKosciuskoIncome
{
    public function getTaxRate(): float
    {
        return 0.01;
    }
}