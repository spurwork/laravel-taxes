<?php

namespace Appleton\Taxes\Countries\US\Ohio\ValleyViewLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class ValleyViewLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '5713';

    protected function getId(): string
    {
        return self::ID;
    }
}
