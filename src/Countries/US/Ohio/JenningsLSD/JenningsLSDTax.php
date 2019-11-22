<?php

namespace Appleton\Taxes\Countries\US\Ohio\JenningsLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class JenningsLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '6903';

    protected function getId(): string
    {
        return self::ID;
    }
}
