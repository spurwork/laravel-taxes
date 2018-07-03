<?php

namespace Appleton\Taxes\Countries\US\Wisconsin\WisconsinIncome\V20180101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Countries\US\Wisconsin\WisconsinIncome\WisconsinIncome as BaseWisconsinIncome;
use Appleton\Taxes\Models\Countries\US\Wisconsin\WisconsinIncomeTaxInformation;

class WisconsinIncome extends BaseWisconsinIncome
{
    const EXEMPTION_AMOUNT = 400;

    const BRACKETS = [
        self::FILING_SINGLE => [
            [0, 0.04, 0],
            [11230, 0.0584, 449.20],
            [22470, 0.0627, 1105.616],
            [247350, 0.0765, 15205.59],
        ],
        self::FILING_MARRIED => [
            [0, 0.04, 0],
            [14980, 0.0584, 599.20],
            [29960, 0.0627, 1474.03],
            [329810, 0.0765, 20274.63],
        ],
        self::FILING_SEPERATE => [
            [0, 0.04, 0],
            [7490, 0.0584, 299.60],
            [14980, 0.0627, 737.02],
            [164900, 0.0765, 10,137.00],
        ],
        self::FILING_HEAD_OF_HOUSEHOLD => [
            [0, 0.04, 0],
            [11230, 0.0584, 449.20],
            [22470, 0.0627, 1105.62],
            [247350, 0.0765, 15205.59],
        ],
    ];

    public function __construct(WisconsinIncomeTaxInformation $tax_information, FederalIncome $federal_income, Payroll $payroll)
    {
        parent::__construct($tax_information, $payroll);
        $this->federal_income_tax = $federal_income->getAmount();
        $this->tax_information = $tax_information;
    }

    public function getAdjustedEarnings()
    {
        // For Wisconsin, standard deduction is built into the tables.
        return $this->getGrossEarnings() - ($this->tax_information->exemptions * self::EXEMPTION_AMOUNT);
    }

    public function getTaxBrackets()
    {
        if (array_key_exists($this->tax_information->filing_status, static::BRACKETS)) {
            return array_get(static::BRACKETS, $this->tax_information->filing_status);
        }

        return static::BRACKETS[static::FILING_SINGLE];
    }

    public function getSupplementalIncomeTax()
    {
        // TODO
        return 0;
    }

    private function getGrossEarnings()
    {
        return ($this->payroll->earnings - $this->payroll->supplemental_earnings) * $this->payroll->pay_periods;
    }
}
