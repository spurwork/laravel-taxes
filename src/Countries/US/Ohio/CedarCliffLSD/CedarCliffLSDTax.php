<?php

namespace Appleton\Taxes\Countries\US\Ohio\CedarCliffLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class CedarCliffLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '2902';

    protected function getId(): string
    {
        return self::ID;
    }
}
