<?php
namespace Appleton\Taxes\Countries\US\Kentucky\ClintonCity\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\ClintonCity\ClintonCity as BaseClintonCity;
use Appleton\Taxes\Traits\HasWageBase;

class ClintonCity extends BaseClintonCity
{
    use HasWageBase;

    public const TAX_RATE = 0.005;
    const WAGE_BASE = 40000;
}
