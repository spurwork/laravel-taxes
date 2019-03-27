<?php

namespace Appleton\Taxes\Countries\US\Maryland\Baltimore\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Maryland\Baltimore\Baltimore as BaseBaltimore;
use Appleton\Taxes\Countries\US\Maryland\MarylandIncome\HasMarylandIncome;
use Appleton\Taxes\Models\Countries\US\Maryland\MarylandIncomeTaxInformation;

class Baltimore extends BaseBaltimore
{
    use HasMarylandIncome;

    const SUPPLEMENTAL_TAX_RATE = 0.05;
    const TAX_RATE = 0.0283;

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
        return [[0, self::TAX_RATE, 0]];
    }

}