<?php

namespace Appleton\Taxes\Countries\US\Ohio\TwinValleyCommunityLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class TwinValleyCommunityLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '6805';

    protected function getId(): string
    {
        return self::ID;
    }
}
