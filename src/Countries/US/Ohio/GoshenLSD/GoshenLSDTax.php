<?php

namespace Appleton\Taxes\Countries\US\Ohio\GoshenLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class GoshenLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '1305';

    protected function getId(): string
    {
        return self::ID;
    }
}
