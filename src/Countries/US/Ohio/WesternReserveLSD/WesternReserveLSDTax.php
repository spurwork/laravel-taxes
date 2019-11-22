<?php

namespace Appleton\Taxes\Countries\US\Ohio\WesternReserveLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class WesternReserveLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '3906';

    protected function getId(): string
    {
        return self::ID;
    }
}
