<?php

namespace Appleton\Taxes\Countries\US\Arkansas\ArkansasIncome;

use Appleton\Taxes\Classes\BaseStateIncome;
use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Models\Countries\US\Arkansas\ArkansasIncomeTaxInformation;

abstract class ArkansasIncome extends BaseStateIncome
{
    public function __construct(ArkansasIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
