<?php
namespace Appleton\Taxes\Countries\US\Maine\MaineIncome;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateIncome;
use Appleton\Taxes\Models\Countries\US\Maine\MaineIncomeTaxInformation;

abstract class MaineIncome extends BaseStateIncome
{
    public const FILING_SINGLE = 'S';
    public const FILING_MARRIED = 'M';

    public const FILING_STATUSES = [
        self::FILING_SINGLE => 'FILING_SINGLE',
        self::FILING_MARRIED => 'FILING_MARRIED',
    ];

    public function __construct(MaineIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
