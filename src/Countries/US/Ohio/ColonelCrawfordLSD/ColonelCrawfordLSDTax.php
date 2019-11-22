<?php

namespace Appleton\Taxes\Countries\US\Ohio\ColonelCrawfordLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class ColonelCrawfordLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '1703';

    protected function getId(): string
    {
        return self::ID;
    }
}
