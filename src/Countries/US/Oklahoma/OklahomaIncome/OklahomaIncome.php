<?php

namespace Appleton\Taxes\Countries\US\Oklahoma\OklahomaIncome;

use Appleton\Taxes\Classes\BaseStateIncome;
use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Models\Countries\US\Oklahoma\OklahomaIncomeTaxInformation;

abstract class OklahomaIncome extends BaseStateIncome
{
    const FILING_SINGLE = 'S';
    const FILING_MARRIED = 'M';

    const FILING_STATUSES = [
        self::FILING_SINGLE => 'FILING_SINGLE',
        self::FILING_MARRIED => 'FILING_MARRIED',
    ];

    protected $tax_information;

    public function __construct(OklahomaIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
