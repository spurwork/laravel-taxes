<?php

namespace Appleton\Taxes\Countries\US\Ohio\FremontCSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class FremontCSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '7202';

    protected function getId(): string
    {
        return self::ID;
    }
}
