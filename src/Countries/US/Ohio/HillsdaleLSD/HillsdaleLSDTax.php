<?php

namespace Appleton\Taxes\Countries\US\Ohio\HillsdaleLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class HillsdaleLSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '0302';

    protected function getId(): string
    {
        return self::ID;
    }
}
