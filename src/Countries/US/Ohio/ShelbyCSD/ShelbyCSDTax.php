<?php

namespace Appleton\Taxes\Countries\US\Ohio\ShelbyCSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class ShelbyCSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '7008';

    protected function getId(): string
    {
        return self::ID;
    }
}
