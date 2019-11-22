<?php

namespace Appleton\Taxes\Countries\US\Ohio\BotkinsLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class BotkinsLSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '7502';

    protected function getId(): string
    {
        return self::ID;
    }
}
