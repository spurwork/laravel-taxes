<?php

namespace Appleton\Taxes\Countries\US\Ohio\PlymouthShilohLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class PlymouthShilohLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '7007';

    protected function getId(): string
    {
        return self::ID;
    }
}
