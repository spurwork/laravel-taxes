<?php

namespace Appleton\Taxes\Countries\US\Ohio\TalawandaCSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class TalawandaCSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '0909';

    protected function getId(): string
    {
        return self::ID;
    }
}
