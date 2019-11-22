<?php

namespace Appleton\Taxes\Countries\US\Ohio\WilmingtonCSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class WilmingtonCSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '1404';

    protected function getId(): string
    {
        return self::ID;
    }
}
