<?php

namespace Appleton\Taxes\Countries\US\Delaware\DelawareIncome;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateIncome;
use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Models\Countries\US\Delaware\DelawareIncomeTaxInformation;

abstract class DelawareIncome extends BaseStateIncome
{
    const FILING_SINGLE = 'S';
    const FILING_MARRIED_FILING_JOINTLY = 'M';
    const FILING_MARRIED_FILING_SEPARATELY = 'S';

    const FILING_STATUSES = [
        self::FILING_SINGLE =>'S',
        self::FILING_MARRIED_FILING_JOINTLY => 'M',
        self::FILING_MARRIED_FILING_SEPARATELY => 'S',
    ];

    const SINGLE_STANDARD_DEDUCTION = 3250;
    const MARRIED_FILING_SEPARATELY_STANDARD_DEDUCTION = 3250;
    const MARRIED_FILING_JOINTLY_STANDARD_DEDUCTION = 6500;

    const WITHHOLDING_TABLE = [
        [0, 0, 0],
        [2000, 0.022, 0],
        [5000, 0.039, 66],
        [10000, 0.048, 261],
        [20000, 0.052, 741],
        [25000, 0.0555, 1001],
        [60000, 0.066, 2943],
    ];

    const EXEMPTION_ALLOWANCE = 110;

    public function __construct(DelawareIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
