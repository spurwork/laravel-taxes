<?php

namespace Appleton\Taxes\Countries\US\California\SanFranciscoPayrollEmployer;

use Appleton\Taxes\Classes\BasePayrollState;
use Illuminate\Support\Collection;

abstract class SanFranciscoPayrollEmployer extends BasePayrollState
{
    abstract public function getStartAmount(): int;

    abstract public function getTaxAmount(): float;

    public function compute(Collection $tax_areas): int
    {
        $ytd_wages = $this->company_payroll->getYtdWages($tax_areas->first()->workGovernmentalUnitArea);
        $wages = $this->company_payroll->getWages($tax_areas->first()->workGovernmentalUnitArea);

        if ($ytd_wages + $wages < $this->getStartAmount()) {
            return 0.0;
        }

        $applicable_wages = $ytd_wages > $this->getStartAmount()
            ? $wages
            : $ytd_wages + $wages - $this->getStartAmount();

        return ceil($applicable_wages * $this->getTaxAmount());
    }

    public function getWages(Collection $tax_areas): int
    {
        return $this->company_payroll->getWages($tax_areas->first()->workGovernmentalUnitArea);
    }
}
