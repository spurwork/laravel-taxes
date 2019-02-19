<?php

namespace Appleton\Taxes\Countries\US\NewYork\NewYorkCity\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\NewYork\NewYorkCity\NewYorkCity as BaseNewYorkCity;
use Appleton\Taxes\Models\Countries\US\NewYork\NewYorkIncomeTaxInformation;

class NewYorkCity extends BaseNewYorkCity
{
    public function __construct(NewYorkIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($tax_information, $payroll);
        $this->tax_information = $tax_information;
    }

    public function compute()
    {
        $this->tax_total = 0;
        return round($this->tax_total, 2);
    }
}
