<?php

namespace Appleton\Taxes\Countries\US\Ohio\EatonCSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class EatonCSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '6803';

    protected function getId(): string
    {
        return self::ID;
    }
}
