<?php
namespace Appleton\Taxes\Countries\US\Kentucky\AlexandriaCity\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\AlexandriaCity\AlexandriaCity as BaseAlexandriaCity;
use Appleton\Taxes\Traits\HasWageBase;

class AlexandriaCity extends BaseAlexandriaCity
{
    use HasWageBase;

    public const TAX_RATE = 0.015;
    const WAGE_BASE = 132900;
}
