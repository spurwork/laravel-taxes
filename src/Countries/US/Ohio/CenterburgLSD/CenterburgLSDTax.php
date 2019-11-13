<?php

namespace Appleton\Taxes\Countries\US\Ohio\CenterburgLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class CenterburgLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '4201';

    protected function getId(): string
    {
        return self::ID;
    }
}
