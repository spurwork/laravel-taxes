<?php

namespace Appleton\Taxes\Countries\US\Arizona\ArizonaIncome\V20180101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Arizona\ArizonaIncome\ArizonaIncome as BaseArizonaIncome;
use Appleton\Taxes\Models\Countries\US\Arizona\ArizonaIncomeTaxInformation;

class ArizonaIncome extends BaseArizonaIncome
{
    const SUPPLEMENTAL_TAX_RATE = 0;

    public function __construct(ArizonaIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($tax_information, $payroll);
        $this->tax_information = $tax_information;
    }

    public function getTaxBrackets()
    {
        return [
            [0, $this->tax_information->percentage_withheld / 100, 0]
        ];
    }

    public function getTaxAmountFromTaxBrackets($amount, $table)
    {
        $bracket = $this->getTaxBracket($amount, $table);
        $tax_amount = isset($bracket) ? ($amount - $bracket[0]) * $bracket[1] + $bracket[2] : 0;
        return $tax_amount > 0 ? $tax_amount : 0;
    }

    public function getAdjustedEarnings()
    {
        return $this->payroll->getEarnings() * $this->payroll->pay_periods;
    }
}
