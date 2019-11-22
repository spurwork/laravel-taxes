<?php

namespace Appleton\Taxes\Countries\US\Ohio\WellingtonEVSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class WellingtonEVSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '4715';

    protected function getId(): string
    {
        return self::ID;
    }
}
