<?php

namespace Appleton\Taxes\Countries\US\Ohio\BerkshireLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class BerkshireLSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '2801';

    protected function getId(): string
    {
        return self::ID;
    }
}
