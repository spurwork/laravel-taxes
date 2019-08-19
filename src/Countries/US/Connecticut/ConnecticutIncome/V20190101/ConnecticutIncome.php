<?php

namespace Appleton\Taxes\Countries\US\Connecticut\ConnecticutIncome\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Connecticut\ConnecticutIncome\ConnecticutIncome as BaseConnecticutIncome;
use Appleton\Taxes\Models\Countries\US\Connecticut\ConnecticutIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

class ConnecticutIncome extends BaseConnecticutIncome
{
    /*
    FILING_MARRIED_FILING_SEPARATELY
    FILING_MARRIED_FILING_JOINTLY_COMBINED_INCOME_LESS_THAN_OR_EQUAL_TO
    FILING_HEAD_OF_HOUSEHOLD
    FILING_MARRIED
    FILING_MARRIED_FILING_JOINTLY_ONE_SPOUSE_WORKING
    FILING_MARRIED_JOINTLY_COMBINED_INCOME_GREATER_THAN
    FILING_SINGLE
    */

    public function __construct(ConnecticutIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }

    public function getTaxBrackets()
    {
    }

    // public function getPersonalExemption()
    // {
    //     $gross_earnings = $this->getGrossEarnings();
    //     $personal_exemption = static::PERSONAL_EXEMPTION[$this->tax_information->filing_status];
    //     $deduction = $personal_exemption['amount'];

    //     if ($gross_earnings > $personal_exemption['base']) {
    //         $deduction -= $personal_exemption['modifier']['amount'] * ceil(($gross_earnings - $personal_exemption['base']) / $personal_exemption['modifier']['per']);
    //     }

    //     return $deduction < $personal_exemption['floor'] ? $personal_exemption['floor'] : $deduction;
    // }
}
