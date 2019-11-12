<?php

namespace Appleton\Taxes\Countries\US\Ohio\PrebleShawneeLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class PrebleShawneeLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '6804';

    protected function getId(): string
    {
        return self::ID;
    }
}
