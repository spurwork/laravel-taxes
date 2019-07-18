<?php
namespace Appleton\Taxes\Countries\US\Kentucky\McLeanCounty\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\McLeanCounty\McLeanCounty as BaseMcLeanCounty;
use Appleton\Taxes\Traits\HasWageBase;

class McLeanCounty extends BaseMcLeanCounty
{
    use HasWageBase;

    public const TAX_RATE = 0.01;
    const WAGE_BASE = 50000;
}
