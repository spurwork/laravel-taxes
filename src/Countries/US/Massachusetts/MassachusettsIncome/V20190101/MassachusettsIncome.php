<?php

namespace Appleton\Taxes\Countries\US\Massachusetts\MassachusettsIncome\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Massachusetts\MassachusettsIncome\MassachusettsIncome as BaseMassachusettsIncome;
use Appleton\Taxes\Countries\US\Medicare\Medicare;
use Appleton\Taxes\Countries\US\SocialSecurity\SocialSecurity;
use Appleton\Taxes\Models\Countries\US\Massachusetts\MassachusettsIncomeTaxInformation;

class MassachusettsIncome extends BaseMassachusettsIncome
{
    const SUPPLEMENTAL_TAX_RATE = 0;

    const TAX_RATE = 0.0505;

    const EXEMPTION_ALLOWANCE_AMOUNT = 1000;

    const EXEMPTION_ALLOWANCE_BASE = 3400;

    const HEAD_OF_HOUSEHOLD_DEDUCTION = 2400;

    public function __construct(MassachusettsIncomeTaxInformation $tax_information, Medicare $medicare, SocialSecurity $social_security, Payroll $payroll)
    {
        parent::__construct($tax_information, $payroll);
        $this->medicare = $medicare->getAmount();
        $this->social_security = $social_security->getAmount();
        $this->tax_information = $tax_information;
    }

    public function getAdjustedEarnings()
    {
        return $this->getGrossEarnings()
            - $this->getAllowanceExemption()
            - ($this->medicare * $this->payroll->pay_periods)
            - ($this->social_security * $this->payroll->pay_periods)
            - ($this->tax_information->filing_status === self::FILING_HEAD_OF_HOUSEHOLD ? self::HEAD_OF_HOUSEHOLD_DEDUCTION : 0);
    }

    public function getTaxBrackets()
    {
        return [[0, self::TAX_RATE, 0]];
    }

    private function getAllowanceExemption()
    {
        return $this->tax_information->exemptions ? $this->tax_information->exemptions * self::EXEMPTION_ALLOWANCE_AMOUNT + self::EXEMPTION_ALLOWANCE_BASE : 0;
    }

    private function getGrossEarnings()
    {
        return $this->payroll->earnings * $this->payroll->pay_periods;
    }
}
