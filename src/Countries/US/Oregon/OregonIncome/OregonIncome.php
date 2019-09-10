<?php

namespace Appleton\Taxes\Countries\US\Oregon\OregonIncome;

use Appleton\Taxes\Classes\BaseStateIncome;
use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Models\Countries\US\Oregon\OregonIncomeTaxInformation;

abstract class OregonIncome extends BaseStateIncome
{
	public function __construct(OregonIncomeTaxInformation $tax_information, Payroll $payroll)
	{
		parent::__construct($payroll);
		$this->tax_information = $tax_information;
	}
}
