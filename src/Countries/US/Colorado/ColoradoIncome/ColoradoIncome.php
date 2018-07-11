<?php

namespace Appleton\Taxes\Countries\US\Colorado\ColoradoIncome;

use Appleton\Taxes\Classes\BaseStateIncome;
use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Models\Countries\US\Colorado\ColoradoIncomeTaxInformation;

abstract class ColoradoIncome extends BaseStateIncome
{
    const FILING_SINGLE = 1;
    const FILING_MARRIED = 2;

    const FILING_STATUSES = [
        self::FILING_SINGLE => 'FILING_SINGLE',
        self::FILING_MARRIED => 'FILING_MARRIED',
    ];

    public function __construct(ColoradoIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }

    public function isUserClaimingExemption(): bool
    {
        return $this->tax_information->exempt;
    }
}
