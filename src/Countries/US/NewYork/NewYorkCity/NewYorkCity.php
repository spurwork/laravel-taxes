<?php

namespace Appleton\Taxes\Countries\US\NewYork\NewYorkCity;

use Appleton\Taxes\Classes\BaseIncome;
use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Models\Countries\US\NewYork\NewYorkIncomeTaxInformation;

abstract class NewYorkCity extends BaseIncome
{
    const TYPE = 'local';

    public function __construct(NewYorkIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
