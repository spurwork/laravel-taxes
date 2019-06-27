<?php

namespace Appleton\Taxes\Countries\US\Kentucky\BooneCountySchoolDistrict\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Kentucky\BooneCountySchoolDistrict\BooneCountySchoolDistrict as BaseBooneCountySchoolDistrict;
use Appleton\Taxes\Models\Countries\US\Kentucky\KentuckyIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

class BooneCountySchoolDistrict extends BaseBooneCountySchoolDistrict
{
    const TAX_RATE = 0.005;

    public function __construct(KentuckyIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($tax_information, $payroll);
    }

    public function compute(Collection $tax_areas)
    {
        if (!$this->tax_information->lives_in_bcsd) {
            return 0.00;
        }

        return parent::compute($tax_areas);
    }
}
