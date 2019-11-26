<?php

namespace Appleton\Taxes\Countries\US\Ohio\PauldingEVSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class PauldingEVSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '6302';

    protected function getId(): string
    {
        return self::ID;
    }
}
