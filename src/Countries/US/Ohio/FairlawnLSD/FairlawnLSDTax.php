<?php

namespace Appleton\Taxes\Countries\US\Ohio\FairlawnLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class FairlawnLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '7503';

    protected function getId(): string
    {
        return self::ID;
    }
}
