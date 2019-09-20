<?php

namespace Appleton\Taxes\Countries\US\Hawaii\HawaiiIncome;

use Appleton\Taxes\Classes\BaseStateIncome;
use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Models\Countries\US\Hawaii\HawaiiIncomeTaxInformation;

abstract class HawaiiIncome extends BaseStateIncome
{
    const FILING_SINGLE = 'S';
    const FILING_MARRIED = 'M';
    const FILING_HEAD_OF_HOUSEHOLD = 'H';

    const FILING_STATUSES = [
        self::FILING_SINGLE =>'S',
        self::FILING_MARRIED => 'M',
        self::FILING_HEAD_OF_HOUSEHOLD => 'H',
    ];

    const SINGLE_WITHHOLDING_TABLE = [
        [0, 0.014, 0],
        [2400, 0.032, 34],
        [4800, 0.055, 110],
        [9600, 0.064, 372],
        [14400, 0.068, 682],
        [19200, 0.072, 1008],
        [24000, 0.076, 1354],
        [36000, 0.079, 2268],
    ];

    const MARRIED_WITHHOLDING_TABLE = [
        [0, 0.014, 0],
        [4800, 0.032, 67],
        [9600, 0.055, 221],
        [19200, 0.064, 749],
        [28800, 0.068, 1363],
        [38400, 0.072, 2016],
        [48000, 0.076, 2707],
        [72000, 0.079, 4531],
    ];

    const EXEMPTION_AMOUNT = 1144;

    public function __construct(HawaiiIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
