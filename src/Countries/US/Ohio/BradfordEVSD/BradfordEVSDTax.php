<?php

namespace Appleton\Taxes\Countries\US\Ohio\BradfordEVSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class BradfordEVSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '5502';

    protected function getId(): string
    {
        return self::ID;
    }
}
