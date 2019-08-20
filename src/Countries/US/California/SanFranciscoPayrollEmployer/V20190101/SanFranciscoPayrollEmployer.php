<?php

namespace Appleton\Taxes\Countries\US\California\SanFranciscoPayrollEmployer\V20190101;

use Appleton\Taxes\Countries\US\California\SanFranciscoPayrollEmployer\SanFranciscoPayrollEmployer as BaseSanFranciscoPayrollEmployer;

class SanFranciscoPayrollEmployer extends BaseSanFranciscoPayrollEmployer
{
    private const START_AMOUNT = 3000000;
    private const TAX_AMOUNT = .0038;

//    public function compute(Collection $tax_areas): float
//    {
//        $ytd_wages = $this->company_payroll->getYtdWages($tax_areas->first());
//        $wages = $this->company_payroll->getWages($tax_areas->first());
//
//        if ($ytd_wages + $wages < self::START_AMOUNT) {
//            return 0.0;
//        }
//
//        $applicable_wages = $ytd_wages > self::START_AMOUNT
//            ? $wages
//            : $ytd_wages + $wages - self::START_AMOUNT;
//
//        return round($applicable_wages * self::TAX_AMOUNT, 4);
//    }
//
//    public function getWages(Collection $tax_areas): float
//    {
//        return $this->company_payroll->getYtdWages($tax_areas->first()) +
//            $wages = $this->company_payroll->getWages($tax_areas->first());
//    }

    public function getStartAmount(): int
    {
        return self::START_AMOUNT;
    }

    public function getTaxAmount(): float
    {
        return self::TAX_AMOUNT;
    }
}
