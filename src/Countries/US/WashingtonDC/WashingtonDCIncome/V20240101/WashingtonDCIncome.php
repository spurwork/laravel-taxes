<?php

namespace Appleton\Taxes\Countries\US\WashingtonDC\WashingtonDCIncome\V20240101;

use Appleton\Taxes\Countries\US\WashingtonDC\WashingtonDCIncome\V20190101\WashingtonDCIncome as WashingtonDCIncome2019;

class WashingtonDCIncome extends WashingtonDCIncome2019
{
    private const TAX_BRACKETS = [
        [0, .04, 0],
        [10000, .06, 400],
        [40000, .065, 2200],
        [60000, .085, 3500],
        [250000, .0925, 19650],
        [500000, .0975, 42775],
        [10000000, .1075, 91525],
    ];

    public function getTaxBrackets()
    {
        return self::TAX_BRACKETS;
    }
}
