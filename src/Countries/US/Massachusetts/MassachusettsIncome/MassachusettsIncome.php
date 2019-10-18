<?php

namespace Appleton\Taxes\Countries\US\Massachusetts\MassachusettsIncome;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateIncome;
use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Models\Countries\US\Massachusetts\MassachusettsIncomeTaxInformation;

abstract class MassachusettsIncome extends BaseStateIncome
{
    const FILING_SINGLE = 0;
    const FILING_MARRIED = 1;
    const FILING_SEPERATE = 2;
    const FILING_HEAD_OF_HOUSEHOLD = 3;

    const FILING_STATUSES = [
        self::FILING_SINGLE => 'FILING_SINGLE',
        self::FILING_MARRIED => 'FILING_MARRIED',
        self::FILING_SEPERATE => 'FILING_SEPERATE',
        self::FILING_HEAD_OF_HOUSEHOLD => 'FILING_HEAD_OF_HOUSEHOLD',
    ];

    public function __construct(MassachusettsIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
