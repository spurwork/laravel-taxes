<?php

namespace Appleton\Taxes\Countries\US\Indiana\JenningsIncome\V20200101;

use Appleton\Taxes\Countries\US\Indiana\JenningsIncome\JenningsIncome as BaseJenningsIncome;

class JenningsIncome extends BaseJenningsIncome
{
    public function getTaxRate(): float
    {
        return 0.025;
    }
}
