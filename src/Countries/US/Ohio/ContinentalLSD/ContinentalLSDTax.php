<?php

namespace Appleton\Taxes\Countries\US\Ohio\ContinentalLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class ContinentalLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '6902';

    protected function getId(): string
    {
        return self::ID;
    }
}
