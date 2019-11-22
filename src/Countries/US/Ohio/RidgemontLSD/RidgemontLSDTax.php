<?php

namespace Appleton\Taxes\Countries\US\Ohio\RidgemontLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class RidgemontLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '3304';

    protected function getId(): string
    {
        return self::ID;
    }
}
