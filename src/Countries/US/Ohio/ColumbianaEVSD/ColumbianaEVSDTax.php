<?php

namespace Appleton\Taxes\Countries\US\Ohio\ColumbianaEVSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class ColumbianaEVSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '1502';

    protected function getId(): string
    {
        return self::ID;
    }
}
