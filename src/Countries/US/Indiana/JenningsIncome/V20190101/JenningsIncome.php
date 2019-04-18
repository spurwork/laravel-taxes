<?php

namespace Appleton\Taxes\Countries\US\Indiana\JenningsIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\JenningsIncome\JenningsIncome as BaseJenningsIncome;

class JenningsIncome extends BaseJenningsIncome
{
    public function getTaxRate(): float
    {
        return 0.0315;
    }
}