<?php

namespace Appleton\Taxes\Countries\US\Ohio\GreeneviewLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class GreeneviewLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '2904';

    protected function getId(): string
    {
        return self::ID;
    }
}
