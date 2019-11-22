<?php

namespace Appleton\Taxes\Countries\US\Ohio\CrestlineEVSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class CrestlineEVSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '1704';

    protected function getId(): string
    {
        return self::ID;
    }
}
