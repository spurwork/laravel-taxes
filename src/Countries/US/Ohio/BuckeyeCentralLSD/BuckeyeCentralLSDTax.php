<?php

namespace Appleton\Taxes\Countries\US\Ohio\BuckeyeCentralLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class BuckeyeCentralLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '1701';

    protected function getId(): string
    {
        return self::ID;
    }
}
