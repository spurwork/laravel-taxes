<?php

namespace Appleton\Taxes\Countries\US\Wisconsin\WisconsinUnemployment\V20180101;

use Appleton\Taxes\Countries\US\Wisconsin\WisconsinUnemployment\WisconsinUnemployment as BaseWisconsinUnemployment;

class WisconsinUnemployment extends BaseWisconsinUnemployment
{
    const FUTA_CREDIT = 0.054;

    // Greater than 500k 3.25%

    const WAGE_BASE = 14000;
}
