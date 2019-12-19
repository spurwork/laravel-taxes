<?php

namespace Appleton\Taxes\Countries\US\Washington\WashingtonWorkersCompensationEmployer\V20190101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Washington\WashingtonWorkersCompensationEmployer\WashingtonWorkersCompensationEmployer as BaseWashingtonWorkersCompensationEmployer;
use Appleton\Taxes\Models\Countries\US\Washington\WashingtonWorkersCompensationTaxInformation;
use Illuminate\Database\Eloquent\Collection;

class WashingtonWorkersCompensationEmployer extends BaseWashingtonWorkersCompensationEmployer
{
    public function __construct(WashingtonWorkersCompensationTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }

    public function compute(Collection $tax_areas)
    {
        $hourly_tax = $this->payroll->withholdTax($this->payroll->getShiftHoursWorked($tax_areas->first()->workGovernmentalUnitArea) * ($this->tax_information->employer_rate / 100));

        if ($this->payroll->getStartDate()->weekOfMonth < 5 && $this->payroll->isSalariedWorker($tax_areas->first()->workGovernmentalUnitArea)) {
            $salaried_tax = $this->payroll->withholdTax(40 * ($this->tax_information->employer_rate / 100));
        } else {
            $salaried_tax = 0;
        }

        return round($hourly_tax + $salaried_tax, 2);
    }
}
