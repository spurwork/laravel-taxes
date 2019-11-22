<?php

namespace Appleton\Taxes\Countries\US\Ohio\LickingValleyLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class LickingValleyLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '4506';

    protected function getId(): string
    {
        return self::ID;
    }
}
