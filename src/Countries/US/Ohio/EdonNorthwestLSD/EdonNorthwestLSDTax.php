<?php

namespace Appleton\Taxes\Countries\US\Ohio\EdonNorthwestLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class EdonNorthwestLSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '8603';

    protected function getId(): string
    {
        return self::ID;
    }
}
