<?php

namespace Appleton\Taxes\Countries\US\Nevada\NevadaUnemployment\V20210101;

use Appleton\Taxes\Countries\US\Nevada\NevadaUnemployment\NevadaUnemployment as BaseNevadaUnemployment;

class NevadaUnemployment extends BaseNevadaUnemployment
{
    public const FUTA_CREDIT = 0.054;
    public const WAGE_BASE = 33400;
}
