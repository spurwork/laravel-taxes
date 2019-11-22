<?php

namespace Appleton\Taxes\Countries\US\Ohio\XeniaCommunityCSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class XeniaCommunityCSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '2906';

    protected function getId(): string
    {
        return self::ID;
    }
}
