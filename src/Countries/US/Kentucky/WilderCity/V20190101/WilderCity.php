<?php
namespace Appleton\Taxes\Countries\US\Kentucky\WilderCity\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\WilderCity\WilderCity as BaseWilderCity;
use Appleton\Taxes\Traits\HasWageBase;

class WilderCity extends BaseWilderCity
{
    use HasWageBase;

    public const TAX_RATE = 0.0225;
    const WAGE_BASE = 132900;
}
