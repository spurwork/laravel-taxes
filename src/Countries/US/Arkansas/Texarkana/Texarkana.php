<?php
namespace Appleton\Taxes\Countries\US\Arkansas\Texarkana;

use Appleton\Taxes\Classes\BaseLocalIncome;
use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Models\Countries\US\Arkansas\ArkansasIncomeTaxInformation;

abstract class Texarkana extends BaseLocalIncome
{
    public function __construct(ArkansasIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
