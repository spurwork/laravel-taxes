<?php

namespace Appleton\Taxes\Countries\US\Ohio\LibertyCenterLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class LibertyCenterLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '3502';

    protected function getId(): string
    {
        return self::ID;
    }
}
