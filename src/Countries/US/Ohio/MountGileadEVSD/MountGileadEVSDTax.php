<?php

namespace Appleton\Taxes\Countries\US\Ohio\MountGileadEVSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class MountGileadEVSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '5903';

    protected function getId(): string
    {
        return self::ID;
    }
}
