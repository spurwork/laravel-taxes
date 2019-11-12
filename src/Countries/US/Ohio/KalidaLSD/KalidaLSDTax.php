<?php

namespace Appleton\Taxes\Countries\US\Ohio\KalidaLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class KalidaLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '6904';

    protected function getId(): string
    {
        return self::ID;
    }
}
