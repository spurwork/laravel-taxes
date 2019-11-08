<?php

namespace Appleton\Taxes\Countries\US\Ohio\MadisonLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class MadisonLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '0905';

    protected function getId(): string
    {
        return self::ID;
    }
}
