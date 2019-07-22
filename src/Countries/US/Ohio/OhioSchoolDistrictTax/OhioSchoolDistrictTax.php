<?php

namespace Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTax;

use Appleton\Taxes\Classes\BaseTax;
use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Models\Countries\US\Ohio\OhioIncomeTaxInformation;

abstract class OhioSchoolDistrictTax extends BaseTax
{
    const TYPE = 'state';
    const WITHHELD = true;

    protected $tax_information;
    protected $payroll;

    public function __construct(OhioIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
