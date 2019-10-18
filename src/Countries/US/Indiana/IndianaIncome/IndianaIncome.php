<?php

namespace Appleton\Taxes\Countries\US\Indiana\IndianaIncome;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateIncome;
use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Models\Countries\US\Indiana\IndianaIncomeTaxInformation;

abstract class IndianaIncome extends BaseStateIncome
{
    public function __construct(IndianaIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
