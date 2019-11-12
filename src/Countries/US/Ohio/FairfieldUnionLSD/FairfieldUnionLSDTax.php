<?php

namespace Appleton\Taxes\Countries\US\Ohio\FairfieldUnionLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class FairfieldUnionLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '2304';

    protected function getId(): string
    {
        return self::ID;
    }
}
