<?php

namespace Appleton\Taxes\Countries\US\NewYork\Yonkers;

use Appleton\Taxes\Classes\BaseLocalIncome;
use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Models\Countries\US\NewYork\NewYorkIncomeTaxInformation;

abstract class Yonkers extends BaseLocalIncome
{
    const FILING_SINGLE = 0;
    const FILING_MARRIED = 1;

    const FILING_STATUSES = [
        self::FILING_SINGLE => 'FILING_SINGLE',
        self::FILING_MARRIED => 'FILING_MARRIED',
    ];

    public function __construct(NewYorkIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
