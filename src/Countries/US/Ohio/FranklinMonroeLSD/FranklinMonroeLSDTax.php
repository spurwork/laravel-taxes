<?php

namespace Appleton\Taxes\Countries\US\Ohio\FranklinMonroeLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class FranklinMonroeLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '1903';

    protected function getId(): string
    {
        return self::ID;
    }
}
