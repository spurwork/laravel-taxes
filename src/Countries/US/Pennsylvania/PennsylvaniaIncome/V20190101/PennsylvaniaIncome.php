<?php
namespace Appleton\Taxes\Countries\US\Pennsylvania\PennsylvaniaIncome\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Pennsylvania\PennsylvaniaIncome\PennsylvaniaIncome as BasePennsylvaniaIncome;
use Appleton\Taxes\Models\Countries\US\Pennsylvania\PennsylvaniaIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

class PennsylvaniaIncome extends BasePennsylvaniaIncome
{
    const TAX_RATE = 0.0307;

    public function compute(Collection $tax_areas)
    {
        if ($this->tax_information->exempt) {
            return 0.0;
        }

        return round($this->payroll->withholdTax($this->getAdjustedEarnings() * self::TAX_RATE), 2);
    }

    public function getTaxBrackets()
    {
    }
}
