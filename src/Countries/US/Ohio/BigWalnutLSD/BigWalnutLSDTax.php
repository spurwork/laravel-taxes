<?php

namespace Appleton\Taxes\Countries\US\Ohio\BigWalnutLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class BigWalnutLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '2101';

    protected function getId(): string
    {
        return self::ID;
    }
}
