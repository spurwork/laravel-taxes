<?php

namespace Appleton\Taxes\Countries\US\Ohio\CirclevilleCSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class CirclevilleCSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '6501';

    protected function getId(): string
    {
        return self::ID;
    }
}
