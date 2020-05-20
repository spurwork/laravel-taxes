<?php

namespace Appleton\Taxes\Countries\US\Pennsylvania\PennsylvaniaLocalEITTax;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseLocalIncome;
use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Models\Countries\US\Pennsylvania\PennsylvaniaIncomeTaxInformation;

abstract class PennsylvaniaLocalEITTax extends BaseLocalIncome
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
