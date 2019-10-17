<?php

namespace Appleton\Taxes\Countries\US\Indiana\ClintonIncome\V20191001;

use Appleton\Taxes\Countries\US\Indiana\ClintonIncome\ClintonIncome as BaseClintonIncome;

class ClintonIncome extends BaseClintonIncome
{
    public function getTaxRate(): float
    {
        return 0.0245;
    }
}
