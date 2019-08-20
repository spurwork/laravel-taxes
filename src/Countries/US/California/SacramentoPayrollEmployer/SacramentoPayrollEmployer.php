<?php

namespace Appleton\Taxes\Countries\US\California\SacramentoPayrollEmployer;

use Appleton\Taxes\Classes\BasePayrollState;
use Appleton\Taxes\Countries\US\California\SacramentoPayrollEmployer\SacramentoPayrollEmployer as BaseSacramentoPayrollEmployer;
use Illuminate\Support\Collection;

abstract class SacramentoPayrollEmployer extends BasePayrollState
{
    abstract public function getInitialTax(): float;

    abstract public function getMaxLiability(): int;

    abstract public function getStartAmount(): int;

    abstract public function getTaxAmount(): float;

    public function compute(Collection $tax_areas): float
    {
        $ytd_wages = $this->company_payroll->getYtdWages($tax_areas->first());
        if ($ytd_wages === 0) {
            return $this->getInitialTax();
        }

        $ytd_liabilities = $this->company_payroll->getYtdLiabilities(BaseSacramentoPayrollEmployer::class);
        if ($ytd_liabilities > $this->getMaxLiability()) {
            return 0.0;
        }

        $wages = $this->company_payroll->getWages($tax_areas->first());
        if ($ytd_wages + $wages < $this->getStartAmount()) {
            return 0.0;
        }

        $applicable_wages = $ytd_wages > $this->getStartAmount()
            ? $wages
            : $ytd_wages + $wages - $this->getStartAmount();

        $liability = $applicable_wages * $this->getTaxAmount();

        return round(min($liability, $this->getMaxLiability() - $ytd_liabilities), 4);
    }

    public function getWages(Collection $tax_areas): float
    {
        return $this->company_payroll->getWages($tax_areas->first());
    }
}
