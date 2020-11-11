<?php

namespace Appleton\Taxes\Countries\US\Minnesota\MinnesotaUnemployment\V20200101;

use Appleton\Taxes\Countries\US\Minnesota\MinnesotaUnemployment\MinnesotaUnemployment as BaseMinnesotaUnemployment;

class MinnesotaUnemployment extends BaseMinnesotaUnemployment
{
    const FUTA_CREDIT = 0.054;
    const WAGE_BASE = 35000;
}
