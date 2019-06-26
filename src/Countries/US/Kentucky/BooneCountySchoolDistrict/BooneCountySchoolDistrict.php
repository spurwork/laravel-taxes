<?php

namespace Appleton\Taxes\Countries\US\Kentucky\BooneCountySchoolDistrict;

use Appleton\Taxes\Classes\BaseOccupational;
use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Models\Countries\US\Kentucky\KentuckyIncomeTaxInformation;

abstract class BooneCountySchoolDistrict extends BaseOccupational
{
    protected $tax_information;

    public function __construct(KentuckyIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
