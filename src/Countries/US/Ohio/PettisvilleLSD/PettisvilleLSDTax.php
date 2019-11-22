<?php

namespace Appleton\Taxes\Countries\US\Ohio\PettisvilleLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class PettisvilleLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '2604';

    protected function getId(): string
    {
        return self::ID;
    }
}
