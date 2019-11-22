<?php

namespace Appleton\Taxes\Countries\US\Ohio\HopewellLoudonLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class HopewellLoudonLSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '7403';

    protected function getId(): string
    {
        return self::ID;
    }
}
