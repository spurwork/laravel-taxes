<?php

namespace Appleton\Taxes\Countries\US\Ohio\YellowSpringsEVSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class YellowSpringsEVSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '2907';

    protected function getId(): string
    {
        return self::ID;
    }
}
