<?php
namespace Appleton\Taxes\Countries\US\Kentucky\HighlandHeightsCity\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\HighlandHeightsCity\HighlandHeightsCity as BaseHighlandHeightsCity;
use Appleton\Taxes\Traits\HasWageBase;

class HighlandHeightsCity extends BaseHighlandHeightsCity
{
    use HasWageBase;

    public const TAX_RATE = 0.01;
    const WAGE_BASE = 100000;
}
