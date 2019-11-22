<?php

namespace Appleton\Taxes\Countries\US\Ohio\CareyEVSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class CareyEVSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '8801';

    protected function getId(): string
    {
        return self::ID;
    }
}
