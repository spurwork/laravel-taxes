<?php

namespace Appleton\Taxes\Countries\US\Ohio\AyersvilleLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class AyersvilleLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '2001';

    protected function getId(): string
    {
        return self::ID;
    }
}
