<?php

namespace Appleton\Taxes\Countries\US\FederalIncome;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseIncome;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;

abstract class FederalIncome extends BaseIncome
{
    const TYPE = 'federal';

    const FILING_SINGLE = 0;
    const FILING_WIDOW = 1;
    const FILING_HEAD_OF_HOUSEHOLD = 2;
    const FILING_MARRIED = 3;
    const FILING_SEPERATE = 4;
    const FILING_JOINTLY = 5;

    const FILING_STATUSES = [
        self::FILING_SINGLE => 'FILING_SINGLE',
        self::FILING_WIDOW => 'FILING_WIDOW',
        self::FILING_HEAD_OF_HOUSEHOLD => 'FILING_HEAD_OF_HOUSEHOLD',
        self::FILING_MARRIED => 'FILING_MARRIED',
        self::FILING_SEPERATE => 'FILING_SEPERATE',
        self::FILING_JOINTLY => 'FILING_JOINTLY',
    ];

    public function __construct(FederalIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
