<?php

namespace Appleton\Taxes\Countries\US\Ohio\TriVillageLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class TriVillageLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '1906';

    protected function getId(): string
    {
        return self::ID;
    }
}
