<?php

namespace Appleton\Taxes\Countries\US\Arizona\ArizonaIncome\V20180101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Arizona\ArizonaIncome\ArizonaIncome as BaseArizonaIncome;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Models\Countries\US\Arizona\ArizonaIncomeTaxInformation;

class ArizonaIncome extends BaseArizonaIncome
{
    public function __construct(ArizonaIncomeTaxInformation $tax_information, FederalIncome $federal_income, Payroll $payroll)
    {
        parent::__construct($tax_information, $payroll);
        $this->federal_income_tax = $federal_income->getAmount();
        $this->tax_information = $tax_information;
    }

    public function getTaxBrackets()
    {
        return $this->tax_information->percentage_withheld;
    }
}
