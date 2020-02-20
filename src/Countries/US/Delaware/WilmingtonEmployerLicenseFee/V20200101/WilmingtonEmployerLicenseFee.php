	<?php

namespace Appleton\Taxes\Countries\US\Delaware\Wilmington\V20200101;

use Appleton\Taxes\Countries\US\Delaware\Wilmington\WilmingtonIncome as BaseWilmingtonIncome;

use Illuminate\Database\Eloquent\Collection;

class WilmingtonIncome extends BaseWilmingtonIncome
{
    const LICENSE_FEE = 15;

    public function compute(Collection $tax_areas)
    {
        $this->tax_total = $this->payroll->withholdTax($this->payroll->getEarnings() + self::LICENSE_FEE);

        return round($this->tax_total, 2);
    }
}
