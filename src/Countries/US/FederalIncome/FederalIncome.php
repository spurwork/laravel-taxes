<?php

namespace Appleton\Taxes\Countries\US\FederalIncome;

use Appleton\Taxes\Classes\BaseIncome;
use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;

abstract class FederalIncome extends BaseIncome
{
    const TYPE = 'federal';
    const WITHHELD = true;

    const FILING_SINGLE = 0;
    const FILING_WIDOW = 1;
    const FILING_HEAD_OF_HOUSEHOLD = 2;
    const FILING_MARRIED = 3;
    const FILING_SEPERATE = 4;

    const FILING_STATUSES = [
        self::FILING_SINGLE => 'FILING_SINGLE',
        self::FILING_WIDOW => 'FILING_WIDOW',
        self::FILING_HEAD_OF_HOUSEHOLD => 'FILING_HEAD_OF_HOUSEHOLD',
        self::FILING_MARRIED => 'FILING_MARRIED',
        self::FILING_SEPERATE => 'FILING_SEPERATE',
    ];

    public function __construct(FederalIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }

    public function isUserClaimingExemption(): bool
    {
        return $this->tax_information->exempt;
    }
}
