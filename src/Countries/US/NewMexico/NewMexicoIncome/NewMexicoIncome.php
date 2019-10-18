<?php

namespace Appleton\Taxes\Countries\US\NewMexico\NewMexicoIncome;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateIncome;
use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Models\Countries\US\NewMexico\NewMexicoIncomeTaxInformation;

abstract class NewMexicoIncome extends BaseStateIncome
{
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

    public function __construct(NewMexicoIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
