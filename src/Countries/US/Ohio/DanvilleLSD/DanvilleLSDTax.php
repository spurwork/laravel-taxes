<?php

namespace Appleton\Taxes\Countries\US\Ohio\DanvilleLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class DanvilleLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '4202';

    protected function getId(): string
    {
        return self::ID;
    }
}
