<?php

namespace Appleton\Taxes\Countries\US\Ohio\WestLibertySalemLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class WestLibertySalemLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '1105';

    protected function getId(): string
    {
        return self::ID;
    }
}
