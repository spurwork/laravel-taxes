<?php

namespace Appleton\Taxes\Countries\US\California\CaliforniaUnemployment\V20190101;

use Appleton\Taxes\Countries\US\California\CaliforniaUnemployment\CaliforniaUnemployment as BaseCaliforniaUnemployment;

class CaliforniaUnemployment extends BaseCaliforniaUnemployment
{
    public const FUTA_CREDIT = 0.054;
    public const WAGE_BASE = 7000;
}
