<?php

namespace Appleton\Taxes\Countries\US\FederalIncome\V20240101;

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
        [16300, 0.1, 0],
        [39500, 0.12, 2320],
        [110600, 0.22, 10852],
        [217350, 0.24, 34337],
        [400200, 0.32, 78221],
        [503750, 0.35, 111357],
        [747500, 0.37, 196669.5],
    ];

    const BRACKETS_SINGLE = [
        [0, 0, 0],
        [6000, 0.1, 0],
        [17600, 0.12, 1160],
        [53150, 0.22, 5426],
        [106525, 0.24, 17168.5],
        [197950, 0.32, 39110.5],
        [249725, 0.35, 55678.5],
        [615350, 0.37, 183647.25],
    ];

    const BRACKETS_HEAD_OF_HOUSEHOLD = [
        [0, 0, 0],
        [13300, 0.1, 0],
        [29850, 0.12, 1655],
        [76400, 0.22, 7241],
        [113800, 0.24, 15469],
        [205250, 0.32, 37417],
        [257000, 0.35, 53977],
        [622650, 0.37, 181954.5],
    ];

    const BRACKETS_MARRIED_STEP_2 = [
        [0, 0, 0],
        [14600, 0.1, 0],
        [26200, 0.12, 1160],
        [61750, 0.22, 5426],
        [115125, 0.24, 17168.5],
        [206550, 0.32, 39110.5],
        [258325, 0.35, 55678.5],
        [380200, 0.37, 98334.75],
    ];

    const BRACKETS_SINGLE_STEP_2 = [
        [0, 0, 0],
        [7300, 0.1, 0],
        [13100, 0.12, 580],
        [30875, 0.22, 2713],
        [57563, 0.24, 8584.25],
        [103275, 0.32, 19555.25],
        [129163, 0.35, 27839.25],
        [311975, 0.37, 91823.63],
    ];

    const BRACKETS_HEAD_OF_HOUSEHOLD_STEP_2 = [
        [0, 0, 0],
        [10950, 0.1, 0],
        [19225, 0.12, 827.5],
        [42500, 0.22, 3620.5],
        [61200, 0.24, 7734.5],
        [106925, 0.32, 18708.5],
        [132800, 0.35, 26988.5],
        [315625, 0.37, 90977.25],
    ];

    public function __construct(FederalIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($tax_information, $payroll);
        $this->tax_information = $tax_information;
    }
}
