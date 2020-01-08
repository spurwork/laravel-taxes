<?php

namespace Appleton\Taxes\Countries\US\Ohio\GreenvilleCSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class GreenvilleCSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '1904';

    protected function getId(): string
    {
        return self::ID;
    }
}
