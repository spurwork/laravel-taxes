<?php

namespace Appleton\Taxes\Countries\US\Ohio\SouthCentralLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class SouthCentralLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '3905';

    protected function getId(): string
    {
        return self::ID;
    }
}
