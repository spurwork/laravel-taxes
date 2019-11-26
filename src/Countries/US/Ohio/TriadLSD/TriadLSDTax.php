<?php

namespace Appleton\Taxes\Countries\US\Ohio\TriadLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class TriadLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '1103';

    protected function getId(): string
    {
        return self::ID;
    }
}
