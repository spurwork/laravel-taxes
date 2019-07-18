<?php
namespace Appleton\Taxes\Countries\US\Kentucky\FortWrightCity\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\FortWrightCity\FortWrightCity as BaseFortWrightCity;
use Appleton\Taxes\Traits\HasWageBase;

class FortWrightCity extends BaseFortWrightCity
{
    use HasWageBase;

    public const TAX_RATE = 0.01;
    const WAGE_BASE = 100000;
}
