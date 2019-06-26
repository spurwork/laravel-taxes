<?php

namespace Appleton\Taxes\Countries\US\Mississippi\MississippiIncome;

use Appleton\Taxes\Classes\BaseStateIncome;
use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Models\Countries\US\Mississippi\MississippiIncomeTaxInformation;

abstract class MississippiIncome extends BaseStateIncome
{
    const FILING_SINGLE = 'S';
    const FILING_MARRIED = 'M';
    const FILING_HEAD_OF_HOUSEHOLD = 'H';

    protected $tax_information;

    public function __construct(MississippiIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
