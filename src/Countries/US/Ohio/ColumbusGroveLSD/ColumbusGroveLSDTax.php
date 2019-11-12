<?php

namespace Appleton\Taxes\Countries\US\Ohio\ColumbusGroveLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class ColumbusGroveLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '6901';

    protected function getId(): string
    {
        return self::ID;
    }
}
