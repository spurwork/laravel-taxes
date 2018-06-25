<?php

namespace Appleton\Taxes\Countries\US\Georgia\GeorgiaIncome;

use Appleton\Taxes\Classes\BaseStateIncome;
use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Models\Countries\US\Georgia\GeorgiaIncomeTaxInformation;

abstract class GeorgiaIncome extends BaseStateIncome
{
    const FILING_ZERO = 0;
    const FILING_SINGLE = 1;
    const FILING_MARRIED_JOINT_BOTH_WORKING = 2;
    const FILING_MARRIED_JOINT_ONE_WORKING = 3;
    const FILING_MARRIED_SEPARATE = 4;
    const FILING_HEAD_OF_HOUSEHOLD = 5;

    const FILING_STATUSES = [
        self::FILING_ZERO => 'FILING_ZERO',
        self::FILING_SINGLE => 'FILING_SINGLE',
        self::FILING_MARRIED_JOINT_BOTH_WORKING => 'FILING_MARRIED_JOINT_BOTH_WORKING',
        self::FILING_MARRIED_JOINT_ONE_WORKING => 'FILING_MARRIED_JOINT_ONE_WORKING',
        self::FILING_MARRIED_SEPARATE => 'FILING_MARRIED_SEPARATE',
        self::FILING_HEAD_OF_HOUSEHOLD => 'FILING_HEAD_OF_HOUSEHOLD',
    ];

    public function __construct(GeorgiaIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }

    public function isExempt(): bool 
    {
        return $this->tax_information->exempt;
    }
}
