<?php

namespace Appleton\Taxes\Countries\US\Ohio\PiquaCSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class PiquaCSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '5507';

    protected function getId(): string
    {
        return self::ID;
    }
}
