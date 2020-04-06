<?php
namespace Appleton\Taxes\Countries\US\Iowa\IowaIncome\V20200101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Countries\US\Iowa\IowaIncome\IowaIncome as BaseIowaIncome;
use Appleton\Taxes\Models\Countries\US\Iowa\IowaIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

class IowaIncome extends BaseIowaIncome
{
    const DEDUCTION_AMOUNT = 40;
    const ZERO_OR_ONE = 1880;
    const TWO_OR_MORE = 4630;

    const TAX_WITHHOLDING_BRACKET = [
        [0, 0.0033, 0],
        [1480, .0067, 4.88],
        [2959, .0225, 14.79],
        [5918, .0414, 81.37],
        [13316, .0563, 387.65],
        [22193, .0596, 887.43],
        [29590, .0625, 1328.29],
        [44385, .0744, 2252.98],
        [66578, .0853, 3904.14],
    ];

    public function __construct(IowaIncomeTaxInformation $tax_information, FederalIncome $federal_income, Payroll $payroll)
    {
        parent::__construct($tax_information, $payroll);
        $this->federal_income_tax = $federal_income->getAmount();
        $this->tax_information = $tax_information;
    }

    public function getTaxBrackets()
    {
        return self::TAX_WITHHOLDING_BRACKET;
    }

    public function compute(Collection $tax_areas)
    {
        if ($this->isUserClaimingExemption()) {
            return 0;
        }

        $this->tax_total = $this->payroll->withholdTax(($this->getTaxAmountFromTaxBrackets($this->getGrossAnnualWages() - $this->getStandardAllowance(), $this->getTaxBrackets()) - $this->getExemptionAllowance()) / $this->payroll->pay_periods) + $this->tax_information-> additional_withholding;

        return round($this->tax_total, 2);
    }

    public function getGrossAnnualWages()
    {
        return (($this->getAdjustedEarnings() * $this->payroll->pay_periods) - ($this->federal_income_tax * $this->payroll->pay_periods));
    }

    public function getStandardAllowance()
    {
        return $this->tax_information->allowances <= 1 ? self::ZERO_OR_ONE : self::TWO_OR_MORE;
    }

    public function getExemptionAllowance()
    {
        return self::DEDUCTION_AMOUNT * $this->tax_information->allowances;
    }
}
