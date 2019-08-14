<?php

namespace Appleton\Taxes\Countries\US\Ohio\NewMiamiLSD;

use Appleton\Taxes\Classes\BaseOccupational;
use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Models\Countries\US\Ohio\OhioIncomeTaxInformation;

abstract class NewMiamiLSDTax extends BaseOccupational
{
    protected $tax_information;
    protected $payroll;

    public function __construct(OhioIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
