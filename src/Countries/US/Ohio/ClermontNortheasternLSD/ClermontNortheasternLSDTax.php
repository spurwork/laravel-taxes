<?php

namespace Appleton\Taxes\Countries\US\Ohio\ClermontNortheasternLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class ClermontNortheasternLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '1303';

    protected function getId(): string
    {
        return self::ID;
    }
}
