<?php

namespace Appleton\Taxes\Countries\US\Oregon\WorkersCompAssessmentFund;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseLocalIncome;
use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Models\Countries\US\Oregon\OregonIncomeTaxInformation;

abstract class WorkersCompAssessmentFund extends BaseLocalIncome
{
    public function __construct(OregonIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }

    public function getTaxBrackets()
    {
        return;
    }
}
