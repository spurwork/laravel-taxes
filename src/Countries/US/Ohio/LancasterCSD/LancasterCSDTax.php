<?php

namespace Appleton\Taxes\Countries\US\Ohio\LancasterCSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class LancasterCSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '2305';

    protected function getId(): string
    {
        return self::ID;
    }
}
