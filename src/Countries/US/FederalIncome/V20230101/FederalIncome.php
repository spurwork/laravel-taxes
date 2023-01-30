<?php

namespace Appleton\Taxes\Countries\US\FederalIncome\V20230101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome as BaseFederalIncome;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;

class FederalIncome extends BaseFederalIncome
{
    const SUPPLEMENTAL_TAX_RATE = 0;
    const CREDIT_STEP_2_MARRIED = 12900;
    const CREDIT_STEP_2_NOT_MARRIED = 8600;
    const CREDIT_VERSION_PRIOR_2020 = 4300;

    const BRACKETS_MARRIED = [
        [0, 0, 0],
        [14800, 0.1, 0],
        [36800, 0.12, 2200],
        [104250, 0.22, 10294],
        [205550, 0.24, 32580],
        [379000, 0.32, 74208],
        [477300, 0.35, 105664],
        [708550, 0.37, 186601.5],
    ];

    const BRACKETS_SINGLE = [
        [0, 0, 0],
        [5250, 0.1, 0],
        [16250, 0.12, 1100],
        [49975, 0.22, 5147],
        [100625, 0.24, 16290],
        [187350, 0.32, 37104],
        [236500, 0.35, 52832],
        [583375, 0.37, 174238.25],
    ];

    const BRACKETS_HEAD_OF_HOUSEHOLD = [
        [0, 0, 0],
        [12200, 0.1, 0],
        [27900, 0.12, 1570],
        [72050, 0.22, 6868],
        [107550, 0.24, 14678],
        [194300, 0.32, 35498],
        [243450, 0.35, 51226],
        [590300, 0.37, 172623.5],
    ];

    const BRACKETS_MARRIED_STEP_2 = [
        [0, 0, 0],
        [13850, 0.1, 0],
        [24850, 0.12, 1100],
        [58575, 0.22, 5147],
        [109225, 0.24, 16290],
        [195950, 0.32, 37104],
        [245100, 0.35, 52832],
        [360725, 0.37, 93300.75],
    ];

    const BRACKETS_SINGLE_STEP_2 = [
        [0, 0, 0],
        [6925, 0.1, 0],
        [12425, 0.12, 550],
        [29288, 0.22, 2573.5],
        [54613, 0.24, 8145],
        [97975, 0.32, 18552],
        [122550, 0.35, 26416],
        [295988, 0.37, 87119.13],
    ];

    const BRACKETS_HEAD_OF_HOUSEHOLD_STEP_2 = [
        [0, 0, 0],
        [10400, 0.1, 0],
        [18250, 0.12, 785],
        [40325, 0.22, 3434],
        [58075, 0.24, 7339],
        [101450, 0.32, 17749],
        [126025, 0.35, 25613],
        [299450, 0.37, 86311.75],
    ];

    public function __construct(FederalIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($tax_information, $payroll);
        $this->tax_information = $tax_information;
    }
}
