<?php

namespace Appleton\Taxes\Countries\US\Kentucky\BooneCountySchoolDistrict;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseOccupational;
use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
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
