<?php

namespace Appleton\Taxes\Countries\US\Virginia\VirginiaIncome;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateIncome;
use Appleton\Taxes\Models\Countries\US\Virginia\VirginiaIncomeTaxInformation;

abstract class VirginiaIncome extends BaseStateIncome
{
    public function __construct(VirginiaIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
