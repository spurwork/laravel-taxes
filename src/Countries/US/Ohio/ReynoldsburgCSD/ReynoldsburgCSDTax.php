<?php

namespace Appleton\Taxes\Countries\US\Ohio\ReynoldsburgCSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class ReynoldsburgCSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '2509';

    protected function getId(): string
    {
        return self::ID;
    }
}
