<?php

namespace Appleton\Taxes\Countries\US\NewJersey\NewJerseyIncome;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateIncome;
use Appleton\Taxes\Models\Countries\US\NewJersey\NewJerseyIncomeTaxInformation;

abstract class NewJerseyIncome extends BaseStateIncome
{
    const FILING_SINGLE = 'S';
    const FILING_MARRIED_CIVIL_UNION_COUPLE_JOINT = 'M';
    const FILING_MARRIED_CIVIL_UNION_COUPLE_SEPARATE = 'C';
    const FILING_HEAD_OF_HOUSEHOLD = 'D';
    const SURVIVING_SPOUSE_SURVIVING_CIVIL_UNION_PARENT = 'E';

    const FILING_STATUSES = [
        self::FILING_SINGLE => 'FILING_SINGLE',
        self::FILING_MARRIED_CIVIL_UNION_COUPLE_JOINT => 'FILING_MARRIED_CIVIL_UNION_COUPLE_JOINT',
        self::FILING_MARRIED_CIVIL_UNION_COUPLE_SEPARATE => 'FILING_MARRIED_CIVIL_UNION_COUPLE_SEPARATE',
        self::FILING_HEAD_OF_HOUSEHOLD => 'FILING_HEAD_OF_HOUSEHOLD',
        self::SURVIVING_SPOUSE_SURVIVING_CIVIL_UNION_PARENT => 'SURVIVING_SPOUSE_SURVIVING_CIVIL_UNION_PARENT',
    ];

    protected $tax_information;

    public function __construct(NewJerseyIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
