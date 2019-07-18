<?php
namespace Appleton\Taxes\Countries\US\Kentucky\AugustaCity\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\AugustaCity\AugustaCity as BaseAugustaCity;
use Appleton\Taxes\Traits\HasWageBase;

class AugustaCity extends BaseAugustaCity
{
    use HasWageBase;

    public const TAX_RATE = 0.0125;
    const WAGE_BASE = 72000;
}
