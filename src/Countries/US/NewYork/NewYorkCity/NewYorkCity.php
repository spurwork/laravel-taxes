<?php

namespace Appleton\Taxes\Countries\US\NewYork\NewYorkCity;

use Appleton\Taxes\Classes\BaseTax;
use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Models\Countries\US\NewYork\NewYorkIncomeTaxInformation;

abstract class NewYorkCity extends BaseTax
{
    const TYPE = 'local';

    public function __construct(NewYorkIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
