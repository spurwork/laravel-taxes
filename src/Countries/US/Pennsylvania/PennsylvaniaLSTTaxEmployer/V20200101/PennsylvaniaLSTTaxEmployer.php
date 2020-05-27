<?php

namespace Appleton\Taxes\Countries\US\Pennsylvania\PennsylvaniaLSTTaxEmployer\V20200101;

use Appleton\Taxes\Countries\US\Pennsylvania\PennsylvaniaLSTTaxEmployer\PennsylvaniaLSTTaxEmployer as BasePennsylvaniaLSTTaxEmployer;
use Illuminate\Database\Eloquent\Collection;

class PennsylvaniaLSTTaxEmployer extends BasePennsylvaniaLSTTaxEmployer
{
    const LST_TRIGGER_AMOUNT = 10;
    const PREVIOUSLY_PAID_LST_TOTAL = 52;

    private $tax_areas;

    public function compute(Collection $tax_areas)
    {
        $this->tax_areas = $tax_areas;
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

        if ($amount_owed + $this->getCatchUpAmount() <= $this->getTotalLSTOwed()) {
            $amount_owed += $this->getCatchUpAmount();
        } else {
            $amount_owed = $this->getTotalLSTOwed();
        }

        if ($this->getPreviouslyPaidLST() > 0) {
            if (self::PREVIOUSLY_PAID_LST_TOTAL - $this->getPreviouslyPaidLST() <= 0) {
                return 0.0;
            }
            if ($this->getPreviouslyPaidLST() < self::PREVIOUSLY_PAID_LST_TOTAL) {
                $previous_amount = $amount_owed - $this->getPreviouslyPaidLST();

                $amount_owed = min($amount_owed, $previous_amount);
            }
        }

        if ($this->getTotalLSTOwed() <= self::LST_TRIGGER_AMOUNT) {
            if ($amount_owed > $this->getTotalLSTOwed()) {
                return $this->getTotalLSTOwed() - $this->getPreviouslyPaidLST();
            }
            return $amount_owed > 0 ? $amount_owed : 0.0;
        } else {
            return $amount_owed > 0 ? $amount_owed / $this->payroll->pay_periods : 0.0;
        }
    }

    public function getTotalLSTOwed()
    {
        return $this->tax_information->municipal_lst_total + $this->tax_information->school_district_lst_total;
    }

    public function getPreviouslyPaidLST()
    {
        return $this->tax_information->lst_paid_to_previous_employers;
    }

    public function isExemptFromMunicipalLST()
    {
        if (!$this->tax_information->exempt_from_municipal_lst || !$this->tax_information->municipal_lst_lie_total || $this->tax_information->municipal_lst_lie_total === 0) {
            return false;
        }

        return true;
    }

    public function isExemptFromSchoolDistrictLST()
    {
        if (!$this->tax_information->exempt_from_school_district_lst || !$this->tax_information->school_district_lst_lie_total || $this->tax_information->school_district_lst_lie_total === 0) {
            return false;
        }

        return true;
    }

    public function previousAmountPaidTowardsLIETotal()
    {
        return $this->payroll->getYtdEarnings($this->tax_areas->first()->workGovernmentalUnitArea) + $this->tax_information->wages_from_previous_employers;
    }

    public function getCatchUpAmount()
    {
        $municipal_amount = 0;
        $school_district_amount = 0;
        $ytd_earnings = 0;

        $ytd_earnings = $this->payroll->getYtdEarnings($this->tax_areas->first()->workGovernmentalUnitArea);
        $ytd_earnings += $this->tax_information->wages_from_previous_employers;
        $ytd_earnings += $this->payroll->getEarnings();

        if ($this->isExemptFromMunicipalLST()) {
            if ($ytd_earnings > $this->tax_information->municipal_lst_lie_total) {
                if ($this->tax_information->municipal_lst_total <= self::LST_TRIGGER_AMOUNT) {
                    $municipal_amount = $this->tax_information->municipal_lst_total;
                } else {
                    if ($this->tax_information->pay_periods_exempt > 0) {
                        $municipal_amount = $this->tax_information->municipal_lst_total / $this->tax_information->pay_periods_exempt;
                    } else {
                        $municipal_amount = $this->tax_information->municipal_lst_total / self::PREVIOUSLY_PAID_LST_TOTAL;
                    }
                }
            }
        }

        if ($this->isExemptFromSchoolDistrictLST()) {
            if ($ytd_earnings > $this->tax_information->school_district_lst_lie_total) {
                if ($this->tax_information->school_district_lst_total <= self::LST_TRIGGER_AMOUNT) {
                    $school_district_amount = $this->tax_information->school_district_lst_total;
                } else {
                    if ($this->tax_information->pay_periods_exempt > 0) {
                        $school_district_amount = $this->tax_information->school_district_lst_total / $this->tax_information->pay_periods_exempt;
                    } else {
                        $school_district_amount = $this->tax_information->school_district_lst_total / self::PREVIOUSLY_PAID_LST_TOTAL;
                    }
                }
            }
        }

        return $municipal_amount + $school_district_amount;
    }
}
