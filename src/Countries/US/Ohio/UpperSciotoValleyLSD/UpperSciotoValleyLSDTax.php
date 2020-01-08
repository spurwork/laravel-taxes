<?php

namespace Appleton\Taxes\Countries\US\Ohio\UpperSciotoValleyLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class UpperSciotoValleyLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '3306';

    protected function getId(): string
    {
        return self::ID;
    }
}
