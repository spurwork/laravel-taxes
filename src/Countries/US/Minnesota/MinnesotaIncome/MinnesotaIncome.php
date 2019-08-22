<?php
namespace Appleton\Taxes\Countries\US\Minnesota\MinnesotaIncome;

use Appleton\Taxes\Classes\BaseStateIncome;
use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Models\Countries\US\Minnesota\MinnesotaIncomeTaxInformation;

abstract class MinnesotaIncome extends BaseStateIncome
{
    const FILING_SINGLE = 'S';
    const FILING_MARRIED = 'M';
    const FILING_MARRIED_BUT_WITHHOLD_AT_HIGHER_SINGLE_RATE = 'R';

    const FILING_STATUSES = [
        self::FILING_SINGLE => 'FILING_SINGLE',
        self::FILING_MARRIED => 'FILING_MARRIED',
        self::FILING_MARRIED => 'FILING_MARRIED_BUT_WITHHOLD_AT_HIGHER_SINGLE_RATE',
    ];

    public function __construct(MinnesotaIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
