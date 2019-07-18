<?php
namespace Appleton\Taxes\Countries\US\Kentucky\NelsonCounty\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\NelsonCounty\NelsonCounty as BaseNelsonCounty;
use Appleton\Taxes\Traits\HasWageBase;

class NelsonCounty extends BaseNelsonCounty
{
    use HasWageBase;

    public const TAX_RATE = 0.005;
    const WAGE_BASE = 15000;
}
