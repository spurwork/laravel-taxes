<?php

namespace Appleton\Taxes\Countries\US\Missouri\MissouriIncome;

use Appleton\Taxes\Classes\BaseStateIncome;
use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Models\Countries\US\Missouri\MissouriIncomeTaxInformation;

abstract class MissouriIncome extends BaseStateIncome
{
    const FILING_SINGLE = 'S';
    const FILING_MARRIED_ONE_SPOUSE_EMPLOYED = 'M';
    const FILING_MARRIED_BOTH_SPOUSES_EMPLOYED = 'N';
    const FILING_HEAD_OF_HOUSEHOLD = 'H';

    const FILING_STATUSES = [
        self::FILING_SINGLE =>'S',
        self::FILING_MARRIED_ONE_SPOUSE_EMPLOYED => 'M',
        self::FILING_MARRIED_BOTH_SPOUSES_EMPLOYED => 'N',
        self::FILING_HEAD_OF_HOUSEHOLD => 'H',
    ];

    const SINGLE_STANDARD_DEDUCTION = 12200;
    const MARRIED_ONE_SPOUSE_WORKING_STANDARD_DEDUCTION = 24400;
    const MARRIED_BOTH_SPOUSE_WORKING_STANDARD_DEDUCTION = 12200;
    const HEAD_OF_HOUSEHOLD_STANDARD_DEDUCTION = 18350;

    const TAX_WITHHOLDING_TABLE = [
        [0, 0.015, 0],
        [1053, 0.02, 15.8],
        [2106, 0.025, 36.86],
        [3159, 0.03, 63.19],
        [4212, 0.035, 94.78],
        [5265, 0.04, 131.64],
        [6318, 0.045, 173.76],
        [7371, 0.05, 221.15],
        [8424, 0.054, 273.8],
    ];

    public function __construct(MissouriIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
