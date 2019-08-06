<?php

namespace Appleton\Taxes\Countries\US\Kansas\KansasIncome;

use Appleton\Taxes\Classes\BaseStateIncome;
use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Models\Countries\US\Kansas\KansasIncomeTaxInformation;

abstract class KansasIncome extends BaseStateIncome
{
    public const ALLOWANCE_RATE_SINGLE = 0;
    public const ALLOWANCE_RATE_JOINT = 1;

    public function __construct(KansasIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
