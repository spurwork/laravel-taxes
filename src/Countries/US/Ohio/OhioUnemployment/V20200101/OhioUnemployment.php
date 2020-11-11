<?php

namespace Appleton\Taxes\Countries\US\Ohio\OhioUnemployment\V20200101;

use Appleton\Taxes\Countries\US\Ohio\OhioUnemployment\OhioUnemployment as BaseOhioUnemployment;

class OhioUnemployment extends BaseOhioUnemployment
{
    const FUTA_CREDIT = 0.054;
    const WAGE_BASE = 9000;
}
