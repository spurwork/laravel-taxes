<?php

namespace Appleton\Taxes\Countries\US\Pennsylvania\PennsylvaniaLSTTaxEmployer\V20200101;

use Appleton\Taxes\Countries\US\Pennsylvania\PennsylvaniaLSTTaxEmployer\PennsylvaniaLSTTaxEmployer as BasePennsylvaniaLSTTaxEmployer;
use Illuminate\Database\Eloquent\Collection;

class PennsylvaniaLSTTaxEmployer extends BasePennsylvaniaLSTTaxEmployer
{
    const LST_TRIGGER_AMOUNT = 10;
    const PREVIOUSLY_PAID_LST_TOTAL = 52;

    private $tax_areas;
    private $municipal_exempt_amount_paid = false;
    private $school_district_exempt_amount_paid = false;


    public function compute(Collection $tax_areas)
    {
        $this->tax_areas = $tax_areas;
        $this->tax_total = $this->getAmountToWithhold();
        return round($this->tax_total, 2);
    }

    public function getAmountToWithhold()
    {
        $catch_up_amount = $this->getCatchUpAmount();
        $amount_owed = $this->getTotalLSTOwedAfterExemptions();
        if ($amount_owed === 0 && $catch_up_amount === 0 || $amount_owed < $this->payroll->getYtdLiabilities(BasePennsylvaniaLSTTaxEmployer::class) || $this->getPreviouslyPaidLST() >= self::PREVIOUSLY_PAID_LST_TOTAL) {
            return 0.0;
        }

        $amount_owed -= $this->payroll->getYtdLiabilities(BasePennsylvaniaLSTTaxEmployer::class);

        if ($amount_owed + $catch_up_amount > $this->getTotalLSTOwed()) {
            $catch_up_amount = 0;
            $amount_owed = $this->getTotalLSTOwed() - $this->payroll->getYtdLiabilities(BasePennsylvaniaLSTTaxEmployer::class);
        }

        if ($this->getTotalLSTOwed() <= self::LST_TRIGGER_AMOUNT) {
            if ($amount_owed > 0 && $catch_up_amount > 0) {
                return $catch_up_amount + ($amount_owed / $this->payroll->pay_periods);
            } elseif ($amount_owed <= 0 && $catch_up_amount > 0) {
                return $catch_up_amount;
            } elseif ($amount_owed > 0 && $catch_up_amount <= 0) {
                return $amount_owed;
            } else {
                return 0.0;
            }
        } else {
            if ($amount_owed > 0 && $catch_up_amount > 0) {
                return $catch_up_amount + ($amount_owed / $this->payroll->pay_periods);
            } elseif ($amount_owed <= 0 && $catch_up_amount > 0) {
                return $catch_up_amount;
            } elseif ($amount_owed > 0 && $catch_up_amount <= 0) {
                return $amount_owed / $this->payroll->pay_periods;
            } else {
                return 0.0;
            }
        }
    }

    public function getTotalLSTOwedAfterExemptions()
    {
        if ($this->tax_information->exempt_from_municipal_lst && $this->tax_information->exempt_from_school_district_lst) {
            return 0;
        } elseif ($this->tax_information->exempt_from_municipal_lst) {
            return $this->tax_information->school_district_lst_total;
        } elseif ($this->tax_information->exempt_from_school_district_lst) {
            return $this->tax_information->municipal_lst_total;
        }

        return $this->tax_information->municipal_lst_total + $this->tax_information->school_district_lst_total;
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

    public function getCatchUpAmount()
    {
        $municipal_amount = 0;
        $school_district_amount = 0;
        $ytd_earnings = 0;

        $ytd_earnings = $this->payroll->getYtdEarnings($this->tax_areas->first()->workGovernmentalUnitArea) + $this->tax_information->wages_from_previous_employers + $this->payroll->getEarnings();

        if ($this->isExemptFromMunicipalLST() && $this->tax_information->exempt_for_low_income && !$this->municipal_exempt_amount_paid) {
            if ($ytd_earnings > $this->tax_information->municipal_lst_lie_total) {
                $this->municipal_exempt_amount_paid = true;
                if ($this->tax_information->municipal_lst_total <= self::LST_TRIGGER_AMOUNT) {
                    $municipal_amount = $this->tax_information->municipal_lst_total;
                } else {
                    $municipal_amount = ($this->tax_information->municipal_lst_total / $this->payroll->pay_periods) * $this->payroll->getPayPeriodsExempt(BasePennsylvaniaLSTTaxEmployer::class);
                }
            }
        }

        if ($this->isExemptFromSchoolDistrictLST() && $this->tax_information->exempt_for_low_income && !$this->school_district_exempt_amount_paid) {
            if ($ytd_earnings > $this->tax_information->school_district_lst_lie_total) {
                $this->school_district_exempt_amount_paid = true;
                if ($this->tax_information->school_district_lst_total <= self::LST_TRIGGER_AMOUNT) {
                    $school_district_amount = $this->tax_information->school_district_lst_total;
                } else {
                    $school_district_amount = ($this->tax_information->school_district_lst_total / $this->payroll->pay_periods) * $this->payroll->getPayPeriodsExempt(BasePennsylvaniaLSTTaxEmployer::class);
                }
            }
        }

        return $municipal_amount + $school_district_amount;
    }
}
