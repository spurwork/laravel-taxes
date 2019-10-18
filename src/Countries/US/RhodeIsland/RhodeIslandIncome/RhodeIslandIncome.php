<?php

namespace Appleton\Taxes\Countries\US\RhodeIsland\RhodeIslandIncome;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateIncome;
use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Models\Countries\US\RhodeIsland\RhodeIslandIncomeTaxInformation;

abstract class RhodeIslandIncome extends BaseStateIncome
{
    const EXEMPTION_AMOUNT = 1000;
    const EXEMPTION_GROSS_WAGES = 227050;

    const TAX_WITHHOLDING_AMOUNT = [
        [0, 0.0375, 0],
        [64050, 0.0475, 2401.88],
        [145600, 0.0599, 6275.5],
    ];

    public function __construct(RhodeIslandIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
