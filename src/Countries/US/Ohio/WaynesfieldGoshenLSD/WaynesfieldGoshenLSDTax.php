<?php

namespace Appleton\Taxes\Countries\US\Ohio\WaynesfieldGoshenLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class WaynesfieldGoshenLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '0606';

    protected function getId(): string
    {
        return self::ID;
    }
}
