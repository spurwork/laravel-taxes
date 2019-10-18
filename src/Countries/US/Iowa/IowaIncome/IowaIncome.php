<?php
namespace Appleton\Taxes\Countries\US\Iowa\IowaIncome;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateIncome;
use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Models\Countries\US\Iowa\IowaIncomeTaxInformation;

abstract class IowaIncome extends BaseStateIncome
{
    public function __construct(IowaIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
