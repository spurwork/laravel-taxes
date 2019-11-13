<?php

namespace Appleton\Taxes\Countries\US\Ohio\HillsboroCSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class HillsboroCSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '3604';

    protected function getId(): string
    {
        return self::ID;
    }
}
