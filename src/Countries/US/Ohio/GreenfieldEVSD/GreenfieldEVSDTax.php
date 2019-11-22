<?php

namespace Appleton\Taxes\Countries\US\Ohio\GreenfieldEVSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class GreenfieldEVSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '3603';

    protected function getId(): string
    {
        return self::ID;
    }
}
