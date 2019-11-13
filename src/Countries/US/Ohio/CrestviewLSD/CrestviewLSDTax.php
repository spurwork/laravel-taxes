<?php

namespace Appleton\Taxes\Countries\US\Ohio\CrestviewLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;
use Illuminate\Database\Eloquent\Collection;

abstract class CrestviewLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID1 = '1503';
    private const ID2 = '8101';

    protected function getId(): string
    {
        return '';
    }

    public function doesApply(Collection $tax_areas): bool
    {
        return $this->tax_information->school_district_id === self::ID1
            || $this->tax_information->school_district_id === self::ID2;
    }
}
