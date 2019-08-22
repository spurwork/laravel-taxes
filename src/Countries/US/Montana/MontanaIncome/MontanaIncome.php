<?php
namespace Appleton\Taxes\Countries\US\Montana\MontanaIncome;

use Appleton\Taxes\Classes\BaseStateIncome;
use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Models\Countries\US\Montana\MontanaIncomeTaxInformation;

abstract class MontanaIncome extends BaseStateIncome
{
    public function __construct(MontanaIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
