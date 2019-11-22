<?php

namespace Appleton\Taxes\Countries\US\Ohio\JacksonCenterLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class JacksonCenterLSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '7506';

    protected function getId(): string
    {
        return self::ID;
    }
}
