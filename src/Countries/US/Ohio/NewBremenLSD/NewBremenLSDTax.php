<?php

namespace Appleton\Taxes\Countries\US\Ohio\NewBremenLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class NewBremenLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '0602';

    protected function getId(): string
    {
        return self::ID;
    }
}
