<?php

namespace Appleton\Taxes\Countries\US\Ohio\EdgertonLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class EdgertonLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '8602';

    protected function getId(): string
    {
        return self::ID;
    }
}
