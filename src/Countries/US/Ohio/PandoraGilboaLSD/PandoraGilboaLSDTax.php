<?php

namespace Appleton\Taxes\Countries\US\Ohio\PandoraGilboaLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class PandoraGilboaLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '6909';

    protected function getId(): string
    {
        return self::ID;
    }
}
