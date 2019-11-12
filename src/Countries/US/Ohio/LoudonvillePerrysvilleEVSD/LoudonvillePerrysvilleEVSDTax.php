<?php

namespace Appleton\Taxes\Countries\US\Ohio\LoudonvillePerrysvilleEVSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class LoudonvillePerrysvilleEVSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '0303';

    protected function getId(): string
    {
        return self::ID;
    }
}
