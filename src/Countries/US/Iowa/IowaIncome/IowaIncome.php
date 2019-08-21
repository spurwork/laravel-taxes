<?php
namespace Appleton\Taxes\Countries\US\Iowa\IowaIncome;

use Appleton\Taxes\Classes\BaseStateIncome;
use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Models\Countries\US\Iowa\IowaIncomeTaxInformation;

abstract class IowaIncome extends BaseStateIncome
{
    public function __construct(IowaIncomeTaxInformation $tax_information, FederalIncome $federal_income, Payroll $payroll)
    {
        parent::__construct($tax_information, $payroll);
        $this->federal_income_tax = $federal_income->getAmount();
        dump($federal_income_tax.' federal_income_tax');
        $this->tax_information = $tax_information;
    }
}
