<?php
namespace Appleton\Taxes\Countries\US\Idaho\IdahoIncome;

use Appleton\Taxes\Classes\BaseStateIncome;
use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Models\Countries\US\Idaho\IdahoIncomeTaxInformation;

abstract class IdahoIncome extends BaseStateIncome
{
    const FILING_SINGLE = 'S';
    const FILING_MARRIED = 'M';
    const FILING_HEAD_OF_HOUSEHOLD = 'H';

    const FILING_STATUSES = [
        self::FILING_SINGLE =>'FILING_SINGLE',
        self::FILING_MARRIED => 'FILING_MARRIED',
        self::FILING_HEAD_OF_HOUSEHOLD => 'FILING_HEAD_OF_HOUSEHOLD',
    ];

    public function __construct(IdahoIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
