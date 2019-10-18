<?php

namespace Appleton\Taxes\Countries\US\Ohio\GreenvilleCSD;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseOccupational;
use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Models\Countries\US\Ohio\OhioIncomeTaxInformation;

abstract class GreenvilleCSDTax extends BaseOccupational
{
    protected $tax_information;
    protected $payroll;

    public function __construct(OhioIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
