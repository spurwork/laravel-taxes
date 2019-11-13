<?php

namespace Appleton\Taxes\Countries\US\Ohio\NewarkCSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class NewarkCSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '4507';

    protected function getId(): string
    {
        return self::ID;
    }
}
