<?php

namespace Appleton\Taxes\Countries\US\Maryland\MarylandIncome;


use Appleton\Taxes\Classes\BaseStateIncome;
use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Models\Countries\US\Maryland\MarylandIncomeTaxInformation;

abstract class MarylandIncome extends BaseStateIncome
{
    const FILING_SINGLE = 1;
    const FILING_MARRIED_HEAD_OF_HOUSEHOLD = 2;
    const FILING_MARRIED = 3;

    const FILING_STATUSES = [
        self::FILING_SINGLE => 'FILING_SINGLE',
        self::FILING_MARRIED_HEAD_OF_HOUSEHOLD => 'FILING_MARRIED_HEAD_OF_HOUSEHOLD',
        self::FILING_MARRIED => 'FILING_MARRIED',
    ];

    public function __construct(MarylandIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}