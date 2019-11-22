<?php

namespace Appleton\Taxes\Countries\US\Ohio\ZaneTraceLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class ZaneTraceLSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '7107';

    protected function getId(): string
    {
        return self::ID;
    }
}
