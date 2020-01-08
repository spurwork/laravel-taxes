<?php

namespace Appleton\Taxes\Countries\US\Ohio\NationalTrailLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class NationalTrailLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '6802';

    protected function getId(): string
    {
        return self::ID;
    }
}
