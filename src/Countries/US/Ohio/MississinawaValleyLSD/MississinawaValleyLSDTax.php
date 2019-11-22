<?php

namespace Appleton\Taxes\Countries\US\Ohio\MississinawaValleyLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class MississinawaValleyLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '1905';

    protected function getId(): string
    {
        return self::ID;
    }
}
