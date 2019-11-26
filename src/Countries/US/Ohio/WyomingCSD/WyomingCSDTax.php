<?php

namespace Appleton\Taxes\Countries\US\Ohio\WyomingCSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class WyomingCSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '3122';

    protected function getId(): string
    {
        return self::ID;
    }
}
