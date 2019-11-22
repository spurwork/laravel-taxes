<?php

namespace Appleton\Taxes\Countries\US\Ohio\LeipsicLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class LeipsicLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '6905';

    protected function getId(): string
    {
        return self::ID;
    }
}
