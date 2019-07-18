<?php
namespace Appleton\Taxes\Countries\US\Kentucky\BurkesvilleCity\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\BurkesvilleCity\BurkesvilleCity as BaseBurkesvilleCity;
use Appleton\Taxes\Traits\HasWageBase;

class BurkesvilleCity extends BaseBurkesvilleCity
{
    use HasWageBase;

    public const TAX_RATE = 0.02;
    const WAGE_BASE = 37500;
}
