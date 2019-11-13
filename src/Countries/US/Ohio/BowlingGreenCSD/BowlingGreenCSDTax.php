<?php

namespace Appleton\Taxes\Countries\US\Ohio\BowlingGreenCSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class BowlingGreenCSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '8701';

    protected function getId(): string
    {
        return self::ID;
    }
}
