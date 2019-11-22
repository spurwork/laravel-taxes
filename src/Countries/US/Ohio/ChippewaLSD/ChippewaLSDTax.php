<?php

namespace Appleton\Taxes\Countries\US\Ohio\ChippewaLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class ChippewaLSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '8501';

    protected function getId(): string
    {
        return self::ID;
    }
}
