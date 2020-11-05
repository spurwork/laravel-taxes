<?php

namespace Appleton\Taxes\Countries\US\SouthDakota\SouthDakotaUnemployment\V20190101;

use Appleton\Taxes\Countries\US\SouthDakota\SouthDakotaUnemployment\SouthDakotaUnemployment as BaseSouthDakotaUnemployment;

class SouthDakotaUnemployment extends BaseSouthDakotaUnemployment
{
    public const FUTA_CREDIT = 0.054;
    public const WAGE_BASE = 15000;
}
