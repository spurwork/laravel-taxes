<?php

namespace Appleton\Taxes\Countries\US\Ohio\HighlandLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class HighlandLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '5902';

    protected function getId(): string
    {
        return self::ID;
    }
}
