<?php

namespace Appleton\Taxes\Countries\US\Ohio\AthensCSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class AthensCSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '0502';

    protected function getId(): string
    {
        return self::ID;
    }
}
