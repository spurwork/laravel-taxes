<?php

namespace Appleton\Taxes\Countries\US\Ohio\BexleyCSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class BexleyCSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '2501';

    protected function getId(): string
    {
        return self::ID;
    }
}
