<?php
namespace Appleton\Taxes\Countries\US\Pennsylvania\PennsylvaniaIncome;

use Appleton\Taxes\Classes\BaseStateIncome;
use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Models\Countries\US\Pennsylvania\PennsylvaniaIncomeTaxInformation;

abstract class PennsylvaniaIncome extends BaseStateIncome
{
    public function __construct(PennsylvaniaIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
