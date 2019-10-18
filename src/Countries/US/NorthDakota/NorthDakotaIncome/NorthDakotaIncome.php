<?php

namespace Appleton\Taxes\Countries\US\NorthDakota\NorthDakotaIncome;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateIncome;
use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Models\Countries\US\NorthDakota\NorthDakotaIncomeTaxInformation;

abstract class NorthDakotaIncome extends BaseStateIncome
{
    public const FILING_SINGLE = 'S';
    public const FILING_MARRIED = 'M';
    public const FILING_HEAD_OF_HOUSEHOLD = 'H';

    public const FILING_STATUSES = [
        self::FILING_SINGLE => 'FILING_SINGLE',
        self::FILING_MARRIED => 'FILING_MARRIED',
        self::FILING_HEAD_OF_HOUSEHOLD => 'FILING_HEAD_OF_HOUSEHOLD',
    ];

    public function __construct(NorthDakotaIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
