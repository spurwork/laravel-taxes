<?php

namespace Appleton\Taxes\Countries\US\Washington\WashingtonWorkersCompensation\V20190101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Washington\WashingtonWorkersCompensation\WashingtonWorkersCompensation as BaseWashingtonWorkersCompensation;
use Illuminate\Database\Eloquent\Collection;

class WashingtonWorkersCompensation extends BaseWashingtonWorkersCompensation
{
    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
    }

    public function compute(Collection $tax_areas)
    {
        $rate = $this->payroll->getWorkerCompRate('WA', 1);
        $hourly_tax = $this->payroll->withholdTax($this->payroll->getShiftHoursWorked($tax_areas->first()->workGovernmentalUnitArea) * ($rate->employee_rate / 100));

        if ($this->payroll->getStartDate()->weekOfMonth < 5 && $this->payroll->isSalariedWorker($tax_areas->first()->workGovernmentalUnitArea)) {
            $salaried_tax = $this->payroll->withholdTax(40 * ($rate->employee_rate / 100));
        } else {
            $salaried_tax = 0;
        }

        return round($hourly_tax + $salaried_tax, 2);
    }
}
