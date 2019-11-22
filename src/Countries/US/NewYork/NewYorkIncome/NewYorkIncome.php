<?php

namespace Appleton\Taxes\Countries\US\NewYork\NewYorkIncome;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateIncome;
use Appleton\Taxes\Models\Countries\US\NewYork\NewYorkIncomeTaxInformation;

abstract class NewYorkIncome extends BaseStateIncome
{
    const FILING_SINGLE = 0;
    const FILING_HEAD_OF_HOUSEHOLD = 1;
    const FILING_MARRIED = 2;

    const FILING_STATUSES = [
        self::FILING_SINGLE => 'FILING_SINGLE',
        self::FILING_HEAD_OF_HOUSEHOLD => 'FILING_HEAD_OF_HOUSEHOLD',
        self::FILING_MARRIED => 'FILING_MARRIED',
    ];

    public function __construct(NewYorkIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
