<?php

namespace Appleton\Taxes\Countries\US\Ohio\HardinHoustonLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class HardinHoustonLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '7505';

    protected function getId(): string
    {
        return self::ID;
    }
}
