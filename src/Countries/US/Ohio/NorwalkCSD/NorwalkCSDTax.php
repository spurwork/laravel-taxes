<?php

namespace Appleton\Taxes\Countries\US\Ohio\NorwalkCSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class NorwalkCSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '3904';

    protected function getId(): string
    {
        return self::ID;
    }
}
