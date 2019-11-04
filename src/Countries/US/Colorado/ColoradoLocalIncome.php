<?php

namespace Appleton\Taxes\Countries\US\Colorado;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseLocal;
use Appleton\Taxes\Models\GovernmentalUnitArea;
use Illuminate\Database\Eloquent\Collection;

abstract class ColoradoLocalIncome extends BaseLocal
{
    abstract public function getMonthlyWageAmount(): int;

    abstract public function getMonthlyTaxAmount(): int;

    abstract protected function getLocalGovernmentalUnitArea(): GovernmentalUnitArea;

    public function compute(Collection $tax_areas): float
    {
        $colorado = $tax_areas->first()->workGovernmentalUnitArea;
        $local_governmental_unit_area = $this->getLocalGovernmentalUnitArea();

        $local_earnings = $this->payroll->getEarnings($local_governmental_unit_area);
        $local_mtd_earnings = $this->payroll->getMtdEarnings($local_governmental_unit_area);
        $colorado_mtd_earnings = $this->payroll->getMtdEarnings($colorado);
        $colorado_earnings = $this->payroll->getEarnings($colorado);

        $monthly_wage_amount = $this->getMonthlyWageAmount() / 100;
        if (($local_earnings === 0.0 && $local_mtd_earnings === 0.0)
            || $colorado_mtd_earnings >= $monthly_wage_amount
            || $colorado_earnings + $colorado_mtd_earnings < $monthly_wage_amount) {
            return 0;
        }

        $monthly_tax_amount = $this->getMonthlyTaxAmount() / 100;
        $this->payroll->withholdTax($monthly_tax_amount);
        return round($monthly_tax_amount, 2);
    }
}
