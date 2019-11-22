<?php

namespace Appleton\Taxes\Countries\US\Ohio\FortRecoveryLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class FortRecoveryLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '5406';

    protected function getId(): string
    {
        return self::ID;
    }
}
