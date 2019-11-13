<?php

namespace Appleton\Taxes\Countries\US\Ohio\UnionSciotoLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class UnionSciotoLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '7106';

    protected function getId(): string
    {
        return self::ID;
    }
}
