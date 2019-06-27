<?php

namespace Appleton\Taxes\Countries\US\Oklahoma\OklahomaIncome\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Oklahoma\OklahomaIncome\OklahomaIncome as BaseOklahomaIncome;
use Appleton\Taxes\Models\Countries\US\Oklahoma\OklahomaIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

class OklahomaIncome extends BaseOklahomaIncome
{
    const TAX_RATE = 0.05;

    const SINGLE_BRACKETS = [
        [0, 0, 0],
        [6350, .005, 0],
        [7350, .01, 5],
        [8850, .02, 20],
        [10100, .03, 45],
        [11250, .04, 79.50],
        [13550, .05, 171.50],
    ];

    const MARRIED_BRACKETS = [
        [0, 0, 0],
        [12700, .005, 0],
        [14700, .01, 10],
        [17700, .02, 40],
        [20200, .03, 90],
        [22500, .04, 159],
        [24900, .05, 255],
    ];

    public function __construct(OklahomaIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($tax_information, $payroll);
    }

    public function compute(Collection $tax_areas)
    {
        if ($this->isUserClaimingExemption()) {
            return 0.00;
        }

        $this->tax_total = $this->payroll->withholdTax($this->getTaxAmountFromTaxBrackets(($this->getAdjustedEarnings() * $this->payroll->pay_periods) - $this->getDependentExemption(), $this->getTaxBrackets()) / $this->payroll->pay_periods);

        return (int)round(intval($this->tax_total * 100) / 100, 0);
    }

    public function getDependentExemption()
    {
        return 1000 * $this->tax_information->dependents;
    }

    public function getTaxBrackets()
    {
        if ($this->tax_information->filing_status === 'M') {
            return SELF::MARRIED_BRACKETS;
        }

        return SELF::SINGLE_BRACKETS;
    }
}
