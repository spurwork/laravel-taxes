<?php

namespace Appleton\Taxes\Countries\US\Ohio\LakotaLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class LakotaLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '7204';

    protected function getId(): string
    {
        return self::ID;
    }
}
