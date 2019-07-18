<?php
namespace Appleton\Taxes\Countries\US\Kentucky\BrooksvilleCity\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\BrooksvilleCity\BrooksvilleCity as BaseBrooksvilleCity;
use Appleton\Taxes\Traits\HasWageBase;

class BrooksvilleCity extends BaseBrooksvilleCity
{
    use HasWageBase;

    public const TAX_RATE = 0.0175;
    const WAGE_BASE = 51428.58;
}
