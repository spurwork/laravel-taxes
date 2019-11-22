<?php

namespace Appleton\Taxes\Countries\US\Ohio\CardingtonLincolnLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class CardingtonLincolnLSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '5901';

    protected function getId(): string
    {
        return self::ID;
    }
}
