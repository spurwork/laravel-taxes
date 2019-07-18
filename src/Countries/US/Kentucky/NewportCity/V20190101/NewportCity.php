<?php
namespace Appleton\Taxes\Countries\US\Kentucky\NewportCity\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\NewportCity\NewportCity as BaseNewportCity;
use Appleton\Taxes\Traits\HasWageBase;

class NewportCity extends BaseNewportCity
{
    use HasWageBase;

    public const TAX_RATE = 0.025;
    const WAGE_BASE = 132900;
}
