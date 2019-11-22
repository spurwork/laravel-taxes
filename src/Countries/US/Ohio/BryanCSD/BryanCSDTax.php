<?php

namespace Appleton\Taxes\Countries\US\Ohio\BryanCSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class BryanCSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '8601';

    protected function getId(): string
    {
        return self::ID;
    }
}
