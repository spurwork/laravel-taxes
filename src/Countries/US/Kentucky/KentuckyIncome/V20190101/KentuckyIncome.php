<?php

namespace Appleton\Taxes\Countries\US\Kentucky\KentuckyIncome\V20190101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Kentucky\KentuckyIncome\KentuckyIncome as BaseKentuckyIncome;
use Appleton\Taxes\Models\Countries\US\Kentucky\KentuckyIncomeTaxInformation;

class KentuckyIncome extends BaseKentuckyIncome
{
    public const SUPPLEMENTAL_TAX_RATE = 0;

    private const TAX_RATE = 0.05;
    private const STANDARD_DEDUCTION = 2590;

    public function __construct(KentuckyIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($tax_information, $payroll);
    }

    public function getTaxBrackets(): array
    {
        return [[0, self::TAX_RATE, 0]];
    }

    public function getAdjustedEarnings(): int
    {
        $gross_wages = $this->payroll->getEarnings() * $this->payroll->pay_periods;
        return $gross_wages - self::STANDARD_DEDUCTION;
    }
}
