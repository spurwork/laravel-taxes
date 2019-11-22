<?php

namespace Appleton\Taxes\Countries\US\Ohio\RiversideLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class RiversideLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '4604';

    protected function getId(): string
    {
        return self::ID;
    }
}
