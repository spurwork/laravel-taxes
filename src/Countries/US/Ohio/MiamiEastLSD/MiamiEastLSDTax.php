<?php

namespace Appleton\Taxes\Countries\US\Ohio\MiamiEastLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class MiamiEastLSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '5504';

    protected function getId(): string
    {
        return self::ID;
    }
}
