<?php

namespace Appleton\Taxes\Countries\US\Ohio\RussiaLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class RussiaLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '7507';

    protected function getId(): string
    {
        return self::ID;
    }
}
