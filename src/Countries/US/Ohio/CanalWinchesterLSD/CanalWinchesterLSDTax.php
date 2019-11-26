<?php

namespace Appleton\Taxes\Countries\US\Ohio\CanalWinchesterLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class CanalWinchesterLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '2502';

    protected function getId(): string
    {
        return self::ID;
    }
}
