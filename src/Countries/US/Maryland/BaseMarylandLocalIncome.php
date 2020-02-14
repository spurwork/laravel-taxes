<?php

namespace Appleton\Taxes\Countries\US\Maryland;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseLocalIncome;
use Appleton\Taxes\Countries\US\Maryland\MarylandIncome\HasMarylandIncome;
use Appleton\Taxes\Models\Countries\US\Maryland\MarylandIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

abstract class BaseMarylandLocalIncome extends BaseLocalIncome
{
    use HasMarylandIncome;

    const SUPPLEMENTAL_TAX_RATE = 0.05;

    const STANDARD_DEDUCTION = [
        'min' => 1500,
        'max' => 2250,
        'percentange' => 0.15,
    ];

    public function __construct(MarylandIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }

    public function getTaxBrackets()
    {
        return [[0, $this->getTaxRate(), 0]];
    }

    abstract public function getTaxRate();

    public function compute(Collection $tax_areas)
    {
        if ($this->tax_information->local_exempt) {
            return 0.00;
        }

        $this->worked_in_delaware = $this->payroll->hasWorkInArea('Delaware');

        $this->tax_total = $this->payroll->withholdTax($this->getTaxAmountFromTaxBrackets($this->getAdjustedEarnings(), $this->getTaxBrackets()) / $this->payroll->pay_periods) +
            $this->payroll->withholdTax($this->getSupplementalIncomeTax()) +
            $this->payroll->withholdTax($this->getAdditionalWithholding());

        return round(intval($this->tax_total * 100) / 100, 2);
    }
}
