<?php

namespace Appleton\Taxes\Countries\US\Ohio\OtsegoLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class OtsegoLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '8707';

    protected function getId(): string
    {
        return self::ID;
    }
}
