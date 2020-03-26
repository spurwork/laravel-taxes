<?php

namespace Appleton\Taxes\Countries\US\Missouri\KansasCity;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseLocalIncome;
use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Models\Countries\US\Missouri\MissouriIncomeTaxInformation;

abstract class KansasCity extends BaseLocalIncome
{
    public function __construct(MissouriIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }

    public function getTaxBrackets()
    {
        return;
    }
}
