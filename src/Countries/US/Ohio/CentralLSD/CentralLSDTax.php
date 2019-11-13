<?php

namespace Appleton\Taxes\Countries\US\Ohio\CentralLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class CentralLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '2002';

    protected function getId(): string
    {
        return self::ID;
    }
}
