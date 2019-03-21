<?php

namespace Appleton\Taxes\Countries\US\Kentucky\KentuckyIncome;

use Appleton\Taxes\Classes\BaseStateIncome;
use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Models\Countries\US\Kentucky\KentuckyIncomeTaxInformation;

abstract class KentuckyIncome extends BaseStateIncome
{
    protected $tax_information;

    public function __construct(KentuckyIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
