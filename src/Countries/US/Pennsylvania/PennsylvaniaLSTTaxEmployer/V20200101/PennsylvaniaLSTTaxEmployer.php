<?php

namespace Appleton\Taxes\Countries\US\Pennsylvania\PennsylvaniaLSTTaxEmployer\V20200101;

use Appleton\Taxes\Countries\US\Pennsylvania\PennsylvaniaLSTTaxEmployer\PennsylvaniaLSTTaxEmployer as BasePennsylvaniaLSTTaxEmployer;
use Illuminate\Database\Eloquent\Collection;

class PennsylvaniaLSTTaxEmployer extends BasePennsylvaniaLSTTaxEmployer
{
    const LST_TRIGGER_AMOUNT = 10;
    const PREVIOUSLY_PAID_LST_TOTAL = 52;

    public function compute(Collection $tax_areas)
    {
        $this->tax_total = $this->getAmountToWithhold();
        return round($this->tax_total, 2);
    }

    public function getAmountToWithhold()
    {
        $amount_owed = $this->getTotalLSTOwed();

        if ($amount_owed === 0 || $amount_owed <= $this->payroll->getYtdLiabilities(BasePennsylvaniaLSTTaxEmployer::class)) {
            return 0.0;
        }

        $amount_owed = min($amount_owed, $amount_owed - $this->payroll->getYtdLiabilities(BasePennsylvaniaLSTTaxEmployer::class));

        if ($this->getPreviouslyPaidLST() > 0) {
            if (self::PREVIOUSLY_PAID_LST_TOTAL - $this->getPreviouslyPaidLST() <= 0) {
                return 0.0;
            }
            if ($this->getPreviouslyPaidLST() < self::PREVIOUSLY_PAID_LST_TOTAL) {
                $previous_amount = self::PREVIOUSLY_PAID_LST_TOTAL - $this->getPreviouslyPaidLST();

                $amount_owed = min($amount_owed, $previous_amount);
            }
        }

        if ($this->getTotalLSTOwed() <= self::LST_TRIGGER_AMOUNT) {
            return $amount_owed > 0 ? $amount_owed : 0.0;
        } else {
            return $amount_owed > 0 ? $amount_owed / $this->payroll->pay_periods : 0.0;
        }
    }

    public function getTotalLSTOwed()
    {
        if ($this->tax_information->exempt_from_municipal_lst && $this->tax_information->exempt_from_school_district_lst) {
            return 0;
        } elseif ($this->tax_information->exempt_from_municipal_lst) {
            return $this->tax_information->school_district_lst_total;
        }

        return $this->tax_information->municipal_lst_total + $this->tax_information->school_district_lst_total;
    }

    public function getPreviouslyPaidLST()
    {
        return $this->tax_information->lst_paid_to_previous_employers;
    }
}
