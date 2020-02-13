<?php

namespace Appleton\Taxes\Countries\US\Utah\UtahIncome\V20190101;

use Appleton\Taxes\Countries\US\Utah\UtahIncome\UtahIncome as BaseUtahIncome;
use Illuminate\Database\Eloquent\Collection;

class UtahIncome extends BaseUtahIncome
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
