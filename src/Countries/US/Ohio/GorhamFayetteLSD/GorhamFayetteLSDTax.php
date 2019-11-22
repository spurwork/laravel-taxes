<?php

namespace Appleton\Taxes\Countries\US\Ohio\GorhamFayetteLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class GorhamFayetteLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '2603';

    protected function getId(): string
    {
        return self::ID;
    }
}
