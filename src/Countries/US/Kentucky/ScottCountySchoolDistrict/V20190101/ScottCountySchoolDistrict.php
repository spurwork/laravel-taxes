<?php

namespace Appleton\Taxes\Countries\US\Kentucky\ScottCountySchoolDistrict\V20190101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Kentucky\ScottCountySchoolDistrict\ScottCountySchoolDistrict as BaseScottCountySchoolDistrict;
use Appleton\Taxes\Models\Countries\US\Kentucky\KentuckyIncomeTaxInformation;

class ScottCountySchoolDistrict extends BaseScottCountySchoolDistrict
{
    const TAX_RATE = 0.005;

    public function __construct(KentuckyIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($tax_information, $payroll);
    }
}
