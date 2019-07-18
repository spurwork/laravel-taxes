<?php
namespace Appleton\Taxes\Countries\US\Kentucky\CovingtonCity\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\CovingtonCity\CovingtonCity as BaseCovingtonCity;
use Appleton\Taxes\Traits\HasWageBase;

class CovingtonCity extends BaseCovingtonCity
{
    use HasWageBase;

    public const TAX_RATE = 0.0245;
    const WAGE_BASE = 132900;
}
