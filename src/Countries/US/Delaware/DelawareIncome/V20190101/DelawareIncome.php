<?php

namespace Appleton\Taxes\Countries\US\Delaware\DelawareIncome\V20190101;

use Appleton\Taxes\Countries\US\Delaware\DelawareIncome\DelawareIncome as BaseDelawareIncome;
use Illuminate\Database\Eloquent\Collection;

class DelawareIncome extends BaseDelawareIncome
{
    public function compute(Collection $tax_areas)
    {
        return 0.0;
    }

    public function getTaxBrackets()
    {
        return 0;
    }
}
