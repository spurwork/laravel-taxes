<?php

namespace Appleton\Taxes\Countries\US\Maryland;

use Appleton\Taxes\Classes\BaseLocalIncome;
use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Maryland\MarylandIncome\HasMarylandIncome;
use Appleton\Taxes\Models\Countries\US\Maryland\MarylandIncomeTaxInformation;

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
}