<?php

namespace Appleton\Taxes\Countries\US\Wisconsin\WisconsinIncome;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateIncome;
use Appleton\Taxes\Models\Countries\US\Wisconsin\WisconsinIncomeTaxInformation;

abstract class WisconsinIncome extends BaseStateIncome
{
    const FILING_SINGLE = 0;
    const FILING_MARRIED = 1;

    const FILING_STATUSES = [
        self::FILING_SINGLE =>'FILING_SINGLE',
        self::FILING_MARRIED => 'FILING_MARRIED',
    ];

    const TAX_BRACKET = [
        [0, .04, 0],
        [10910, .0584, 436.4],
        [21820, .0627, 1073.54],
        [240190, .0765, 14765.34],
    ];

    const EXEMPTION_AMOUNT = 400;
    const SINGLE_STANDARD_DEDUCTION_AMOUNT = 5730;
    const MARRIED_STANDARD_DEDUCTION_AMOUNT = 7870;

    public function __construct(WisconsinIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
