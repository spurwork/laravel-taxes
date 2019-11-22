<?php

namespace Appleton\Taxes\Countries\US\Ohio\JohnstownMonroeLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class JohnstownMonroeLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '4503';

    protected function getId(): string
    {
        return self::ID;
    }
}
