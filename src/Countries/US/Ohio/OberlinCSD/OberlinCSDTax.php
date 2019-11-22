<?php

namespace Appleton\Taxes\Countries\US\Ohio\OberlinCSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class OberlinCSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '4712';

    protected function getId(): string
    {
        return self::ID;
    }
}
