<?php

namespace Appleton\Taxes\Countries\US\Ohio\BlufftonEVSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class BlufftonEVSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '0203';

    protected function getId(): string
    {
        return self::ID;
    }
}
