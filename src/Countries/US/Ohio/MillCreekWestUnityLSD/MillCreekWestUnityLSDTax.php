<?php

namespace Appleton\Taxes\Countries\US\Ohio\MillcreekWestUnityLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class MillcreekWestUnityLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '8604';

    protected function getId(): string
    {
        return self::ID;
    }
}
