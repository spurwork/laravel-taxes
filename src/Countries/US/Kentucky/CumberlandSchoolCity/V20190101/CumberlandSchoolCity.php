<?php
namespace Appleton\Taxes\Countries\US\Kentucky\CumberlandSchoolCity\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\CumberlandSchoolCity\CumberlandSchoolCity as BaseCumberlandSchoolCity;
use Appleton\Taxes\Traits\HasWageBase;

class CumberlandSchoolCity extends BaseCumberlandSchoolCity
{
    use HasWageBase;

    public const TAX_RATE = 0.005;
    const WAGE_BASE = 100000;
}
