<?php

namespace Appleton\Taxes\Countries\US\Ohio\NewKnoxvilleLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class NewKnoxvilleLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '0603';

    protected function getId(): string
    {
        return self::ID;
    }
}
