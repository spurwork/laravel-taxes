<?php

namespace Appleton\Taxes\Countries\US\Ohio\EvergreenLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class EvergreenLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '2602';

    protected function getId(): string
    {
        return self::ID;
    }
}
