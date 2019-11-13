<?php

namespace Appleton\Taxes\Countries\US\Ohio\NorthBaltimoreLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class NorthBaltimoreLSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '8705';

    protected function getId(): string
    {
        return self::ID;
    }
}
