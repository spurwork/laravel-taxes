<?php

namespace Appleton\Taxes\Countries\US\Maryland\MarylandIncome;


use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateIncome;
use Appleton\Taxes\Models\Countries\US\Maryland\MarylandIncomeTaxInformation;

abstract class MarylandIncome extends BaseStateIncome
{
    const FILING_SINGLE = 1;
    const FILING_MARRIED_HEAD_OF_HOUSEHOLD = 2;

    const FILING_STATUSES = [
        self::FILING_SINGLE => 'FILING_SINGLE',
        self::FILING_MARRIED_HEAD_OF_HOUSEHOLD => 'FILING_MARRIED_HEAD_OF_HOUSEHOLD',
    ];

    public function __construct(MarylandIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
