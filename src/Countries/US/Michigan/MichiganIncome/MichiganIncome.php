<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganIncome;

use Appleton\Taxes\Classes\BaseStateIncome;
use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Models\Countries\US\Michigan\MichiganIncomeTaxInformation;

abstract class MichiganIncome extends BaseStateIncome
{
    const FILING_SINGLE = 1;
    const FILING_MARRIED_HEAD_OF_HOUSEHOLD = 2;

    const FILING_STATUSES = [
        self::FILING_SINGLE => 'FILING_SINGLE',
        self::FILING_MARRIED_HEAD_OF_HOUSEHOLD => 'FILING_MARRIED_HEAD_OF_HOUSEHOLD',
    ];

    public function __construct(MichiganIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
