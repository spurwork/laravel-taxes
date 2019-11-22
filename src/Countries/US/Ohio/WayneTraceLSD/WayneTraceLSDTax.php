<?php

namespace Appleton\Taxes\Countries\US\Ohio\WayneTraceLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class WayneTraceLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '6303';

    protected function getId(): string
    {
        return self::ID;
    }
}
