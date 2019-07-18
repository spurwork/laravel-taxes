<?php
namespace Appleton\Taxes\Countries\US\Kentucky\CumberlandCounty\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\CumberlandCounty\CumberlandCounty as BaseCumberlandCounty;
use Appleton\Taxes\Traits\HasWageBase;

class CumberlandCounty extends BaseCumberlandCounty
{
    use HasWageBase;

    public const TAX_RATE = 0.0125;
    const WAGE_BASE = 60000;
}
