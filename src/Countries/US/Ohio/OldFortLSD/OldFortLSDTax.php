<?php

namespace Appleton\Taxes\Countries\US\Ohio\OldFortLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class OldFortLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '7405';

    protected function getId(): string
    {
        return self::ID;
    }
}
