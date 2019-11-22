<?php

namespace Appleton\Taxes\Countries\US\Ohio\ParkwayLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class ParkwayLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '5405';

    protected function getId(): string
    {
        return self::ID;
    }
}
