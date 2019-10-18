<?php

namespace Appleton\Taxes\Countries\US\Kentucky\ScottCountySchoolDistrict;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseOccupational;
use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Models\Countries\US\Kentucky\KentuckyIncomeTaxInformation;

abstract class ScottCountySchoolDistrict extends BaseOccupational
{
    protected $tax_information;

    public function __construct(KentuckyIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
