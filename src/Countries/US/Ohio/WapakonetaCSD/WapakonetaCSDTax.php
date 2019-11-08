<?php

namespace Appleton\Taxes\Countries\US\Ohio\WapakonetaCSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class WapakonetaCSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '0605';

    protected function getId(): string
    {
        return self::ID;
    }
}
