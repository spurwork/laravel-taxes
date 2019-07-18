<?php
namespace Appleton\Taxes\Countries\US\Kentucky\ParkHillsCity\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\ParkHillsCity\ParkHillsCity as BaseParkHillsCity;
use Appleton\Taxes\Traits\HasWageBase;

class ParkHillsCity extends BaseParkHillsCity
{
    use HasWageBase;

    public const TAX_RATE = 0.015;
    const WAGE_BASE = 50000;
}
