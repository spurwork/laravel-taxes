<?php

namespace Appleton\Taxes\Countries\US\Arizona\ArizonaIncome;

use Appleton\Taxes\Classes\BaseStateIncome;
use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Models\Countries\US\Arizona\ArizonaIncomeTaxInformation;

abstract class ArizonaIncome extends BaseStateIncome
{
    public function __construct(ArizonaIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }

    public function isUserClaimingExemption(): bool
    {
        return $this->tax_information->exempt;
    }
}
