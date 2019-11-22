<?php

namespace Appleton\Taxes\Countries\US\Utah\UtahIncome;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateIncome;
use Appleton\Taxes\Models\Countries\US\Utah\UtahIncomeTaxInformation;

abstract class UtahIncome extends BaseStateIncome
{
    public const FILING_SINGLE = 'S';
    public const FILING_MARRIED = 'M';

    public const FILING_STATUSES = [
        self::FILING_SINGLE => 'FILING_SINGLE',
        self::FILING_MARRIED => 'FILING_MARRIED',
    ];

    public function __construct(UtahIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
