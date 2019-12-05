<?php

namespace Appleton\Taxes\Countries\US\Kentucky\KentuckyIncome;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateIncome;
use Appleton\Taxes\Models\Countries\US\Kentucky\KentuckyIncomeTaxInformation;

abstract class KentuckyIncome extends BaseStateIncome
{
    protected $tax_information;

    public function __construct(KentuckyIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }

    abstract protected function getTaxRate(): float;

    abstract protected function getStandardDeduction(): int;

    public function getTaxBrackets(): array
    {
        return [[0, $this->getTaxRate(), 0]];
    }

    public function getAdjustedEarnings(): float
    {
        $gross_wages = $this->payroll->getEarnings() * $this->payroll->pay_periods;
        return $gross_wages - $this->getStandardDeduction();
    }
}
