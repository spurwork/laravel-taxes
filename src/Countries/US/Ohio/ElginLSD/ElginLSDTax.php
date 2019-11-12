<?php

namespace Appleton\Taxes\Countries\US\Ohio\ElginLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class ElginLSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '5101';

    protected function getId(): string
    {
        return self::ID;
    }
}
