<?php

namespace Appleton\Taxes\Countries\US\Ohio\WillardCSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class WillardCSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '3907';

    protected function getId(): string
    {
        return self::ID;
    }
}
