<?php

namespace Appleton\Taxes\Countries\US\Ohio\MechanicsburgEVSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\MechanicsburgEVSD\MechanicsburgEVSDTax as BaseMechanicsburgEVSDTax;

class MechanicsburgEVSDTax extends BaseMechanicsburgEVSDTax
{
    public const TAX_RATE = 0.015;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
