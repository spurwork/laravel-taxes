<?php

namespace Appleton\Taxes\Countries\US\Ohio\MiltonUnionEVSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class MiltonUnionEVSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '5505';

    protected function getId(): string
    {
        return self::ID;
    }
}
