<?php

namespace Appleton\Taxes\Countries\US\Ohio\HolgateLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class HolgateLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '3501';

    protected function getId(): string
    {
        return self::ID;
    }
}
