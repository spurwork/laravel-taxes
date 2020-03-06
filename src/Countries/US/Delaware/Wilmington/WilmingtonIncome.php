<?php

namespace Appleton\Taxes\Countries\US\Delaware\Wilmington;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseLocalIncome;
use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Models\Countries\US\Delaware\DelawareIncomeTaxInformation;

abstract class WilmingtonIncome extends BaseLocalIncome
{
    public function __construct(DelawareIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }

    public function getTaxBrackets()
    {
        return;
    }
}
