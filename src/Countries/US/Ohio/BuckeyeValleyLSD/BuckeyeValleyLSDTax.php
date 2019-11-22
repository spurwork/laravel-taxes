<?php

namespace Appleton\Taxes\Countries\US\Ohio\BuckeyeValleyLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class BuckeyeValleyLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '2102';

    protected function getId(): string
    {
        return self::ID;
    }
}
