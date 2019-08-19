<?php

namespace Appleton\Taxes\Countries\US\California\SacramentoPayrollEmployer\V20190101;

use Appleton\Taxes\Countries\US\California\SacramentoPayrollEmployer\SacramentoPayrollEmployer as BaseSacramentoPayrollEmployer;
use Illuminate\Support\Collection;

class SacramentoPayrollEmployer extends BaseSacramentoPayrollEmployer
{
    private const INITIAL_TAX = 30.0000;
    private const START_AMOUNT = 1000000;
    private const MAX_LIABILITY = 500000;
    private const TAX_AMOUNT = .000004;

    public function compute(Collection $tax_areas): float
    {
        $ytd_wages = $this->company_payroll->getYtdWages($tax_areas->first());
        if ($ytd_wages === 0) {
            return self::INITIAL_TAX;
        }

        $ytd_liabilities = $this->company_payroll->getYtdLiabilities(BaseSacramentoPayrollEmployer::class);
        if ($ytd_liabilities > self::MAX_LIABILITY) {
            return 0.0;
        }

        $wages = $this->company_payroll->getWages();
        if ($ytd_wages + $wages < self::START_AMOUNT) {
            return 0.0;
        }

        $applicable_wages = $ytd_wages > self::START_AMOUNT
            ? $wages
            : $ytd_wages + $wages - self::START_AMOUNT;

        $liability = $applicable_wages * self::TAX_AMOUNT;

        return round(min($liability, self::MAX_LIABILITY - $ytd_liabilities), 4);
    }
}
