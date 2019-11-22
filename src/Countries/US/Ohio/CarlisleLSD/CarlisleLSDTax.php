<?php

namespace Appleton\Taxes\Countries\US\Ohio\CarlisleLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class CarlisleLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '8301';

    protected function getId(): string
    {
        return self::ID;
    }
}
