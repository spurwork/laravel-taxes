<?php

namespace Appleton\Taxes\Countries\US\Ohio\VanlueLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class VanlueLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '3208';

    protected function getId(): string
    {
        return self::ID;
    }
}
