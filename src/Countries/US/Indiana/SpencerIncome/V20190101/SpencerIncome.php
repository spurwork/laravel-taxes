<?php

namespace Appleton\Taxes\Countries\US\Indiana\SpencerIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\SpencerIncome\SpencerIncome as BaseSpencerIncome;

class SpencerIncome extends BaseSpencerIncome
{
    public function getTaxRate(): float
    {
        return 0.008;
    }
}