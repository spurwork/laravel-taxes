<?php

namespace Appleton\Taxes\Countries\US\Ohio\DefianceCSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class DefianceCSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '2003';

    protected function getId(): string
    {
        return self::ID;
    }
}
