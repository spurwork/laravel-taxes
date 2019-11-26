<?php

namespace Appleton\Taxes\Countries\US\Ohio\ArcanumButlerLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class ArcanumButlerLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '1902';

    protected function getId(): string
    {
        return self::ID;
    }
}
