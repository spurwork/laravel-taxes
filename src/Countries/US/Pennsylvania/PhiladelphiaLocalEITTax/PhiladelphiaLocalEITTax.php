<?php

namespace Appleton\Taxes\Countries\US\Pennsylvania\PhiladelphiaLocalEITTax;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseLocalIncome;
use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Models\Countries\US\Pennsylvania\PennsylvaniaIncomeTaxInformation;

abstract class PhiladelphiaLocalEITTax extends BaseLocalIncome
{
    public function __construct(PennsylvaniaIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }

    public function getTaxBrackets()
    {
        return;
    }
}
