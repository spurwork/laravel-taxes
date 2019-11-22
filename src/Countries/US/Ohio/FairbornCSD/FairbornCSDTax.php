<?php

namespace Appleton\Taxes\Countries\US\Ohio\FairbornCSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class FairbornCSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '2903';

    protected function getId(): string
    {
        return self::ID;
    }
}
