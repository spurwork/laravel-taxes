<?php

namespace Appleton\Taxes\Countries\US\Ohio\ArcadiaLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class ArcadiaLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '3201';

    protected function getId(): string
    {
        return self::ID;
    }
}
