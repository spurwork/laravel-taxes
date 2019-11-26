<?php

namespace Appleton\Taxes\Countries\US\Ohio\NewLondonLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class NewLondonLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '3903';

    protected function getId(): string
    {
        return self::ID;
    }
}
