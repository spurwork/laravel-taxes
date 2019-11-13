<?php

namespace Appleton\Taxes\Countries\US\Ohio\CoryRawsonLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class CoryRawsonLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '3203';

    protected function getId(): string
    {
        return self::ID;
    }
}
