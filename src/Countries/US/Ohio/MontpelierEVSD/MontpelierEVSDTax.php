<?php

namespace Appleton\Taxes\Countries\US\Ohio\MontpelierEVSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class MontpelierEVSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '8605';

    protected function getId(): string
    {
        return self::ID;
    }
}
