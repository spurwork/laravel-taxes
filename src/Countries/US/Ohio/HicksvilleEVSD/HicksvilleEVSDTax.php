<?php

namespace Appleton\Taxes\Countries\US\Ohio\HicksvilleEVSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class HicksvilleEVSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '2004';

    protected function getId(): string
    {
        return self::ID;
    }
}
