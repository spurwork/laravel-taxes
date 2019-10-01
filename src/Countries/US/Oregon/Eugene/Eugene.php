<?php

namespace Appleton\Taxes\Countries\US\Oregon\Eugene;

use Appleton\Taxes\Classes\BaseLocalIncome;
use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Models\Countries\US\Oregon\OregonIncomeTaxInformation;

abstract class Eugene extends BaseLocalIncome
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
