<?php
namespace Appleton\Taxes\Countries\US\Kentucky\ColdSpringCity\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\ColdSpringCity\ColdSpringCity as BaseColdSpringCity;
use Appleton\Taxes\Traits\HasWageBase;

class ColdSpringCity extends BaseColdSpringCity
{
    use HasWageBase;

    public const TAX_RATE = 0.01;
    const WAGE_BASE = 132900;
}
