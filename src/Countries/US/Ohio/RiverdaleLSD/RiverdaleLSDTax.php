<?php

namespace Appleton\Taxes\Countries\US\Ohio\RiverdaleLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class RiverdaleLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '3305';

    protected function getId(): string
    {
        return self::ID;
    }
}
