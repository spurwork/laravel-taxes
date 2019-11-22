<?php

namespace Appleton\Taxes\Countries\US\Ohio\VanWertCSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class VanWertCSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '8104';

    protected function getId(): string
    {
        return self::ID;
    }
}
