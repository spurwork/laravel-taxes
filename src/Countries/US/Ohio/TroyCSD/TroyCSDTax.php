<?php

namespace Appleton\Taxes\Countries\US\Ohio\TroyCSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class TroyCSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '5509';

    protected function getId(): string
    {
        return self::ID;
    }
}
