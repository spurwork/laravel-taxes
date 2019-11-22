<?php

namespace Appleton\Taxes\Countries\US\Ohio\ClydeGreenSpringsEVSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class ClydeGreenSpringsEVSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '7201';

    protected function getId(): string
    {
        return self::ID;
    }
}
