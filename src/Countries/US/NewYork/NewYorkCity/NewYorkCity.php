<?php

namespace Appleton\Taxes\Countries\US\NewYork\NewYorkCity;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseLocalIncome;
use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Models\Countries\US\NewYork\NewYorkIncomeTaxInformation;

abstract class NewYorkCity extends BaseLocalIncome
{
    public function __construct(NewYorkIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
