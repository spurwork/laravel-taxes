<?php

namespace Appleton\Taxes\Countries\US\Ohio\UpperSanduskyEVSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class UpperSanduskyEVSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '8803';

    protected function getId(): string
    {
        return self::ID;
    }
}
