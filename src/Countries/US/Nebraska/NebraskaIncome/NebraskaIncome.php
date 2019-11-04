<?php

namespace Appleton\Taxes\Countries\US\Nebraska\NebraskaIncome;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateIncome;
use Appleton\Taxes\Models\Countries\US\Nebraska\NebraskaIncomeTaxInformation;

abstract class NebraskaIncome extends BaseStateIncome
{
    const FILING_SINGLE = 'S';
    const FILING_MARRIED = 'M';
    const FILING_HEAD_OF_HOUSEHOLD = 'H';

    const FILING_STATUSES = [
        self::FILING_SINGLE => 'Filing Single',
        self::FILING_MARRIED => 'Filing Married',
        self::FILING_HEAD_OF_HOUSEHOLD => 'Filing Head of Household',
    ];

    public function __construct(NebraskaIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
