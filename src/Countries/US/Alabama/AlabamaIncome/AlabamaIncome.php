<?php

namespace Appleton\Taxes\Countries\US\Alabama\AlabamaIncome;

use Appleton\Taxes\Classes\BaseStateIncome;
use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Models\Countries\US\Alabama\AlabamaIncomeTaxInformation;


abstract class AlabamaIncome extends BaseStateIncome
{
    const FILING_ZERO = 0;
    const FILING_SINGLE = 1;
    const FILING_HEAD_OF_HOUSEHOLD = 2;
    const FILING_MARRIED = 3;
    const FILING_SEPARATE = 4;

    const FILING_STATUSES = [
        self::FILING_ZERO => 'FILING_ZERO',
        self::FILING_SINGLE => 'FILING_SINGLE',
        self::FILING_HEAD_OF_HOUSEHOLD => 'FILING_HEAD_OF_HOUSEHOLD',
        self::FILING_MARRIED => 'FILING_MARRIED',
        self::FILING_SEPARATE => 'FILING_SEPARATE',
    ];

    public function __construct(AlabamaIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
