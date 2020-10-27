<?php

namespace Appleton\Taxes\Countries\US\Ohio\MillCreekWestUnityLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class MillCreekWestUnityLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '8604';

    protected function getId(): string
    {
        return self::ID;
    }
}
