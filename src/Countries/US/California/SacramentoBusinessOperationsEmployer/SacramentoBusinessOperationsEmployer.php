<?php

namespace Appleton\Taxes\Countries\US\California\SacramentoBusinessOperationsEmployer;

use Appleton\Taxes\Classes\BasePayrollLiabilityLocal;
use Appleton\Taxes\Countries\US\California\SacramentoBusinessOperationsEmployer\SacramentoBusinessOperationsEmployer as BaseSacramentoPayrollEmployer;
use Illuminate\Support\Collection;

abstract class SacramentoBusinessOperationsEmployer extends BasePayrollLiabilityLocal
{
    abstract public function getInitialTax(): int;

    abstract public function getMaxLiability(): int;

    abstract public function getStartAmount(): int;

    abstract public function getTaxAmount(): float;

    public function compute(Collection $tax_areas): int
    {
        $ytd_liabilities = $this->company_payroll->getYtdLiabilities(BaseSacramentoPayrollEmployer::class);
        if ($ytd_liabilities > $this->getMaxLiability()) {
            return 0;
        }

        $wages = $this->company_payroll->getWages($tax_areas->first()->workGovernmentalUnitArea);
        if($wages === 0) {
            return 0;
        }

        $ytd_wages = $this->company_payroll->getYtdWages($tax_areas->first()->workGovernmentalUnitArea);
        if ($ytd_wages + $wages < $this->getStartAmount()) {
            if($ytd_wages === 0) {
                return $this->getInitialTax();
            }

            return 0;
        }

        $applicable_wages = $ytd_wages > $this->getStartAmount()
            ? $wages
            : $ytd_wages + $wages - $this->getStartAmount();

        $liability = $applicable_wages * $this->getTaxAmount();

        if($ytd_wages === 0) {
            $liability += $this->getInitialTax();
        }

        return ceil(min($liability, $this->getMaxLiability() - $ytd_liabilities));
    }

    public function getWages(Collection $tax_areas): int
    {
        return $this->company_payroll->getWages($tax_areas->first()->workGovernmentalUnitArea);
    }
}
