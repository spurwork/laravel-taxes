<?php

namespace Appleton\Taxes\Countries\US\Georgia\GeorgiaIncome\V20230101;

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

    const SINGLE_WORKING_BRACKETS = [
        [0, 0.01, 0],
        [1000, 0.02, 10],
        [3000, 0.03, 50],
        [5000, 0.04, 110],
        [7000, 0.05, 190],
        [10000, 0.0575, 340],
    ];

    const BOTH_WORKING_BRACKETS = [
        [0, 0.01, 0],
        [500, 0.02, 5],
        [1500, 0.03, 25],
        [2500, 0.04, 55],
        [3500, 0.05, 95],
        [5000, 0.0575, 170],
    ];

    const SINGLE_BRACKETS = [
        [0, 0.01, 0],
        [750, 0.02, 7.5],
        [2250, 0.03, 37.5],
        [3750, 0.04, 82.5],
        [5250, 0.05, 142.5],
        [7000, 0.0575, 230],
    ];

    const STANDARD_DEDUCTIONS = [
        self::FILING_SINGLE => 5400,
        self::FILING_HEAD_OF_HOUSEHOLD => 5400,
        self::FILING_MARRIED_SEPARATE => 3550,
        self::FILING_MARRIED_JOINT_BOTH_WORKING => 3550,
        self::FILING_MARRIED_JOINT_ONE_WORKING => 7100,
    ];

    const PERSONAL_EXEMPTION_ALLOWANCES = [
        self::FILING_SINGLE => 2700,
        self::FILING_HEAD_OF_HOUSEHOLD => 2700,
        self::FILING_MARRIED_SEPARATE => 3700,
        self::FILING_MARRIED_JOINT_BOTH_WORKING => 3700,
        self::FILING_MARRIED_JOINT_ONE_WORKING => 7400,
    ];

    const DEPENDENT_ALLOWANCE_AMOUNT = GeorgiaIncome2018::DEPENDENT_ALLOWANCE_AMOUNT;

    public function __construct(GeorgiaIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($tax_information, $payroll);
        $this->tax_information = $tax_information;
    }
}
