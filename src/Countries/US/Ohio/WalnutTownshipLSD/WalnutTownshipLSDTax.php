<?php

namespace Appleton\Taxes\Countries\US\Ohio\WalnutTownshipLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class WalnutTownshipLSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '2308';

    protected function getId(): string
    {
        return self::ID;
    }
}
