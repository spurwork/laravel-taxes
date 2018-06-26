<?php

namespace Appleton\Taxes\Countries\US\Wisconsin\WisconsinIncome\V20180101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Wisconsin\WisconsinIncome\WisconsinIncome as BaseWisconsinIncome;
use Appleton\Taxes\Models\Countries\US\Wisconsin\WisconsinIncomeTaxInformation;

class WisconsinIncome extends BaseWisconsinIncome
{
    const BRACKETS = [
        self::FILING_SINGLE => [
            [0, 0.04, 0],
            [11230, 0.0584, 449.20],
            [22470, 0.0627, 1105.62],
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

    const STANDARD_DEDUCTIONS = [
        self::FILING_SINGLE => [
            [0, 14960, 10380, 0, 0],
            [14960, 101460, 10380, .12, 14960],
        ],
        self::FILING_MARRIED => [
            [0, 21590, 19210, 0, 0],
            [21590, 118718, 19210, .19778, 21590],
        ],
        self::FILING_SEPERATE => [
            [0, 10250, 9130, 0, 0],
            [10250, 56412, 9130, .19778, 10250],
        ],
        self::FILING_HEAD_OF_HOUSEHOLD => [
            [0, 14960, 13400, 0, 0],
            [14960, 43682, 14960, .22515, 14960],
            [43682, 101460, 10380, .12, 14960]
        ],
    ];

    public function __construct(WisconsinIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }

    public function getAdjustedEarnings()
    {
        $adjusted_earnings = $this->getGrossEarnings();

        if ($this->tax_information->filing_status != static::FILING_ZERO) {
            $adjusted_earnings = $adjusted_earnings - $this->getStandardDeduction();
        }

        return $adjusted_earnings;
    }

    public function getTaxBrackets()
    {
        if (array_key_exists($this->tax_information->filing_status, static::STANDARD_DEDUCTIONS)) {
            return array_get(static::BRACKETS, $this->tax_information->filing_status);
        }

        return static::BRACKETS[static::FILING_SINGLE];
    }

    public function getSupplementalIncomeTax()
    {
        // TODO
        return 0;
    }

    private function getStandardDeduction()
    {
        if (array_key_exists($this->tax_information->filing_status, static::STANDARD_DEDUCTIONS)) {
            $brackets = array_get(static::STANDARD_DEDUCTIONS, $this->tax_information->filing_status);
            $gross_earnings = $this->getGrossEarnings();

            foreach($brackets as $bracket) {
                if ($gross_earnings >= $bracket[0] && $gross_earnings < $bracket[1]) {
                    return $bracket[2] - ($bracket[3] * ($gross_earnings - $bracket[4]));
                }
            }
        }

        return 0;
    }

    private function getGrossEarnings()
    {
        return ($this->payroll->earnings - $this->payroll->supplemental_earnings) * $this->payroll->pay_periods;
    }
}
