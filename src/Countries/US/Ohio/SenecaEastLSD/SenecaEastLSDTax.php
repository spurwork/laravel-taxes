<?php

namespace Appleton\Taxes\Countries\US\Ohio\SenecaEastLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class SenecaEastLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '7406';

    protected function getId(): string
    {
        return self::ID;
    }
}
