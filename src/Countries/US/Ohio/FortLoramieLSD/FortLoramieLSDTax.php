<?php

namespace Appleton\Taxes\Countries\US\Ohio\FortLoramieLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class FortLoramieLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '7504';

    protected function getId(): string
    {
        return self::ID;
    }
}
