<?php

namespace Appleton\Taxes\Countries\US\Nevada\NevadaGrossPayrollEmployer;

use Appleton\Taxes\Classes\PayrollLiabilities\Liabilities\BasePayrollLiabilityState;
use Illuminate\Support\Collection;

abstract class NevadaGrossPayrollEmployer extends BasePayrollLiabilityState
{
    abstract protected function getStartAmount(): int;

    abstract protected function getTaxAmount(): float;

    public function compute(Collection $tax_areas): int
    {
        $qtd_wages = $this->company_payroll->getQtdWages($tax_areas->first()->workGovernmentalUnitArea);
        $wages = $this->company_payroll->getWages($tax_areas->first()->workGovernmentalUnitArea);

        if ($qtd_wages + $wages < $this->getStartAmount()) {
            return 0.0;
        }

        $applicable_wages = $qtd_wages > $this->getStartAmount()
            ? $wages
            : $qtd_wages + $wages - $this->getStartAmount();

        return ceil($applicable_wages * $this->getTaxAmount());
    }

    public function getWages(Collection $tax_areas): int
    {
        $governmental_unit_area = $tax_areas->first()->governmental_unit_area;
        $wages = $this->company_payroll->getQtdWages($governmental_unit_area) + $this->company_payroll->getWages($governmental_unit_area);
        return max($wages - $this->getStartAmount(), 0);
    }
}
