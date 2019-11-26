<?php

namespace Appleton\Taxes\Countries\US\Ohio\LondonCSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class LondonCSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '4903';

    protected function getId(): string
    {
        return self::ID;
    }
}
