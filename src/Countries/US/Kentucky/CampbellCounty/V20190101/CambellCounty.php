<?php
namespace Appleton\Taxes\Countries\US\Kentucky\CampbellCounty\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\CampbellCounty\CampbellCounty as BaseCampbellCounty;
use Appleton\Taxes\Traits\HasWageBase;

class CampbellCounty extends BaseCampbellCounty
{
    use HasWageBase;

    public const TAX_RATE = 0.0105;
    const WAGE_BASE = 38667;
}
