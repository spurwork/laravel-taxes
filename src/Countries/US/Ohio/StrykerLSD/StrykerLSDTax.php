<?php

namespace Appleton\Taxes\Countries\US\Ohio\StrykerLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class StrykerLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '8607';

    protected function getId(): string
    {
        return self::ID;
    }
}
