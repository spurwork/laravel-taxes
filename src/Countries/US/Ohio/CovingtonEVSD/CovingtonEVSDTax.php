<?php

namespace Appleton\Taxes\Countries\US\Ohio\CovingtonEVSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class CovingtonEVSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '5503';

    protected function getId(): string
    {
        return self::ID;
    }
}
