<?php

namespace Appleton\Taxes\Countries\US\Ohio\SpencervilleLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class SpencervilleLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '0209';

    protected function getId(): string
    {
        return self::ID;
    }
}
