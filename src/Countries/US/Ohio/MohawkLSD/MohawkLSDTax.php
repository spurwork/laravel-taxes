<?php

namespace Appleton\Taxes\Countries\US\Ohio\MohawkLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class MohawkLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '8802';

    protected function getId(): string
    {
        return self::ID;
    }
}
