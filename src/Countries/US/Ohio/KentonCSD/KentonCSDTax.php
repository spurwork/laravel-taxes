<?php

namespace Appleton\Taxes\Countries\US\Ohio\KentonCSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class KentonCSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '3303';

    protected function getId(): string
    {
        return self::ID;
    }
}
