<?php

namespace Appleton\Taxes\Countries\US\Ohio\NorthwesternLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class NorthwesternLSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '1204';

    protected function getId(): string
    {
        return self::ID;
    }
}
