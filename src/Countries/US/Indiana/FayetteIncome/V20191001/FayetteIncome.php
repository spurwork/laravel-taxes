<?php

namespace Appleton\Taxes\Countries\US\Indiana\FayetteIncome\V20191001;

use Appleton\Taxes\Countries\US\Indiana\FayetteIncome\FayetteIncome as BaseFayetteIncome;

class FayetteIncome extends BaseFayetteIncome
{
    public function getTaxRate(): float
    {
        return 0.0257;
    }
}
