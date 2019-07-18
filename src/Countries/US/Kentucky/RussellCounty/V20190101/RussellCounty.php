<?php
namespace Appleton\Taxes\Countries\US\Kentucky\RussellCounty\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\RussellCounty\RussellCounty as BaseRussellCounty;
use Appleton\Taxes\Traits\HasWageBase;

class RussellCounty extends BaseRussellCounty
{
    use HasWageBase;

    public const TAX_RATE = 0.0075;
    const WAGE_BASE = 33333.33;
}
