<?php

namespace Appleton\Taxes\Countries\US\Georgia\GeorgiaIncome\V20190101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Georgia\GeorgiaIncome\GeorgiaIncome as BaseGeorgiaIncome;
use Appleton\Taxes\Countries\US\Georgia\GeorgiaIncome\V20180101\GeorgiaIncome as GeorgiaIncome2018;
use Appleton\Taxes\Models\Countries\US\Georgia\GeorgiaIncomeTaxInformation;

class GeorgiaIncome extends BaseGeorgiaIncome
{
    const SUPPLEMENTAL_TAX_BRACKETS = [
        [15001, .0575],
        [12001, .05],
        [10001, .04],
        [8000, .03],
        [0, .02],
    ];

    const SINGLE_BRACKETS = [
        [0, 0.01, 0],
        [750, 0.02, 7.5],
        [2250, 0.03, 37.5],
        [3750, 0.04, 82.5],
        [5250, 0.05, 142.5],
        [7000, 0.0575, 230],
    ];

    const BOTH_WORKING_BRACKETS = GeorgiaIncome2018::BOTH_WORKING_BRACKETS;

    const SINGLE_WORKING_BRACKETS = GeorgiaIncome2018::SINGLE_WORKING_BRACKETS;

    const STANDARD_DEDUCTIONS = [
        self::FILING_SINGLE => 4600,
        self::FILING_HEAD_OF_HOUSEHOLD => 4600,
        self::FILING_MARRIED_SEPARATE => 3000,
        self::FILING_MARRIED_JOINT_BOTH_WORKING => 3000,
        self::FILING_MARRIED_JOINT_ONE_WORKING => 6000,
    ];

    const PERSONAL_EXEMPTION_ALLOWANCES = GeorgiaIncome2018::PERSONAL_EXEMPTION_ALLOWANCES;

    const DEPENDENT_ALLOWANCE_AMOUNT = GeorgiaIncome2018::DEPENDENT_ALLOWANCE_AMOUNT;

    public function __construct(GeorgiaIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($tax_information, $payroll);
        $this->tax_information = $tax_information;
    }

    protected function getPersonalAllowance(): int
    {
        if ($this->tax_information->getPersonalAllowance() === 0 || !array_key_exists($this->tax_information->getFilingStatus(), self::PERSONAL_EXEMPTION_ALLOWANCES)) {
            return 0;
        }

        if ($this->tax_information->isFilingMarriedOneWorking()) {
            if ($this->tax_information->hasSinglePersonalAllowance()) {
                return self::PERSONAL_EXEMPTION_ALLOWANCES[self::FILING_MARRIED_SEPARATE];
            }
            return self::PERSONAL_EXEMPTION_ALLOWANCES[$this->tax_information->getFilingStatus()] * $this->tax_information->getPersonalAllowance();
        }

        return self::PERSONAL_EXEMPTION_ALLOWANCES[$this->tax_information->getFilingStatus()] * $this->tax_information->getPersonalAllowance();
    }
}
