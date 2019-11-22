<?php

namespace Appleton\Taxes\Countries\US\Ohio\OttawaGlandorfLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class OttawaGlandorfLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '6907';

    protected function getId(): string
    {
        return self::ID;
    }
}
