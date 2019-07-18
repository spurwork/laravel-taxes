<?php
namespace Appleton\Taxes\Countries\US\Kentucky\CrestviewHillsCity\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\CrestviewHillsCity\CrestviewHillsCity as BaseCrestviewHillsCity;
use Appleton\Taxes\Traits\HasWageBase;

class CrestviewHillsCity extends BaseCrestviewHillsCity
{
    use HasWageBase;

    public const TAX_RATE = 0.0115;
    const WAGE_BASE = 132900;
}
