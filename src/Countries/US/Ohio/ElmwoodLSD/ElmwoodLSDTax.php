<?php

namespace Appleton\Taxes\Countries\US\Ohio\ElmwoodLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class ElmwoodLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '8703';

    protected function getId(): string
    {
        return self::ID;
    }
}
