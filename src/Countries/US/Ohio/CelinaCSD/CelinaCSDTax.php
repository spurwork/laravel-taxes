<?php

namespace Appleton\Taxes\Countries\US\Ohio\CelinaCSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class CelinaCSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '5401';

    protected function getId(): string
    {
        return self::ID;
    }
}
