<?php

namespace Appleton\Taxes\Countries\US\Ohio\NorwayneLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class NorwayneLSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '8504';

    protected function getId(): string
    {
        return self::ID;
    }
}
