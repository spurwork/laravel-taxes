<?php

namespace Appleton\Taxes\Countries\US\Ohio\FairbanksLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class FairbanksLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '8001';

    protected function getId(): string
    {
        return self::ID;
    }
}
