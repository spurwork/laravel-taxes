<?php

namespace Appleton\Taxes\Countries\US\Ohio\ColdwaterEVSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class ColdwaterEVSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '5402';

    protected function getId(): string
    {
        return self::ID;
    }
}
