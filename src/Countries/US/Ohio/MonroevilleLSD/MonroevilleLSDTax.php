<?php

namespace Appleton\Taxes\Countries\US\Ohio\MonroevilleLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class MonroevilleLSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '3902';

    protected function getId(): string
    {
        return self::ID;
    }
}
