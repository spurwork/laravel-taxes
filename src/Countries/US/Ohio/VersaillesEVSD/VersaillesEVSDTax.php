<?php

namespace Appleton\Taxes\Countries\US\Ohio\VersaillesEVSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class VersaillesEVSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '1907';

    protected function getId(): string
    {
        return self::ID;
    }
}
