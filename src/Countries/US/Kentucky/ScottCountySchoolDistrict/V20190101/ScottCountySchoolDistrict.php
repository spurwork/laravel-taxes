<?php

namespace Appleton\Taxes\Countries\US\Kentucky\ScottCountySchoolDistrict\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Kentucky\ScottCountySchoolDistrict\ScottCountySchoolDistrict as BaseScottCountySchoolDistrict;
use Appleton\Taxes\Models\Countries\US\Kentucky\KentuckyIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

class ScottCountySchoolDistrict extends BaseScottCountySchoolDistrict
{
    const TAX_RATE = 0.005;

    public function __construct(KentuckyIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($tax_information, $payroll);
    }

    public function compute(Collection $tax_areas)
    {
        if (!$this->tax_information->lives_in_scsd) {
            return 0.00;
        }

        return parent::compute($tax_areas);
    }
}
