<?php

namespace Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTax\V20190101;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTax\OhioSchoolDistrictTax as BaseOhioSchoolDistrictTax;
use Illuminate\Database\Eloquent\Collection;

class OhioSchoolDistrictTax extends BaseOhioSchoolDistrictTax
{
    protected $tax_rate;
    protected $has_traditional_wage_base;

    // id => [tax rate, traditional wage base]
    const TRADITIONAL_TAX_BASE_SCHOOL_ID = [
        '3301' => [0.015, true],
        '7501' => [0.015, true],
        '1901' => [0.0175, true],
        '6301' => [0.015, true],
        '3201' => [0.01, true],
        '1902' => [0.015, true],
        '3202' => [0.0125, true],
        '2001' => [0.01, true],
        '3901' => [0.005, true],
        '2501' => [0.0075, true],
        '2101' => [0.0075, true],
        '2303' => [0.0125, true],
        '0203' => [0.005, true],
        '8701' => [0.005, true],
        '5502' => [0.0175, true],
        '8601' => [0.01, true],
        '1701' => [0.015, true],
        '2102' => [0.01, true],
        '2502' => [0.0075, true],
        '8801' => [0.01, true],
        '8301' => [0.01, true],
        '2902' => [0.0125, true],
        '4201' => [0.0075, true],
        '2002' => [0.0075, true],
        '1303' => [0.01, true],
        '5402' => [0.005, true],
        '1703' => [0.0125, true],
        '1502' => [0.01, true],
        '6901' => [0.01, true],
        '6902' => [0.01, true],
        '3203' => [0.0175, true],
        '5503' => [0.02, true],
        '1503' => [0.01, true],
        '8101' => [0.01, true],
        '8502' => [0.0075, true],
        '4202' => [0.015, true],
        '2003' => [0.005, true],
        '6803' => [0.015, true],
        '8602' => [0.01, true],
        '8703' => [0.0125, true],
        '2602' => [0.0175, true],
        '8001' => [0.01, true],
        '2903' => [0.005, true],
        '2304' => [0.02, true],
        '7503' => [0.0075, true],
        '7504' => [0.015, true],
        '5406' => [0.015, true],
        '1903' => [0.0075, true],
        '7202' => [0.0125, true],
        '2603' => [0.01, true],
        '1305' => [0.01, true],
        '2904' => [0.01, true],
        '1904' => [0.005, true],
        '7505' => [0.0075, true],
        '3302' => [0.0175, true],
        '2004' => [0.0075, true],
        '5902' => [0.005, true],
        '3604' => [0.01, true],
        '3501' => [0.015, true],
        '6903' => [0.0075, true],
        '4503' => [0.01, true],
        '6904' => [0.01, true],
        '3303' => [0.01, true],
        '7204' => [0.015, true],
        '6905' => [0.0075, true],
        '3205' => [0.0075, true],
        '3502' => [0.0175, true],
        '2306' => [0.0175, true],
        '4506' => [0.01, true],
        '4903' => [0.01, true],
        '0303' => [0.0125, true],
        '0905' => [0.005, true],
        '3206' => [0.015, true],
        '1102' => [0.015, true],
        '8604' => [0.01, true],
        '6906' => [0.0125, true],
        '0601' => [0.01, true],
        '1905' => [0.0175, true],
        '8802' => [0.01, true],
        '5903' => [0.0075, true],
        '6802' => [0.0175, true],
        '0602' => [0.01, true],
        '0603' => [0.0125, true],
        '5708' => [0.0125, true],
        '3903' => [0.01, true],
        '0907' => [0.01, true],
        '7404' => [0.015, true],
        '4507' => [0.01, true],
        '5506' => [0.0175, true],
        '8003' => [0.01, true],
        '5904' => [0.01, true],
        '8505' => [0.0125, true],
        '3904' => [0.005, true],
        '4712' => [0.02, true],
        '7405' => [0.01, true],
        '8707' => [0.01, true],
        '6907' => [0.005, true],
        '6908' => [0.0075, true],
        '6909' => [0.0175, true],
        '5405' => [0.01, true],
        '3504' => [0.0175, true],
        '6302' => [0.01, true],
        '8708' => [0.005, true],
        '2604' => [0.01, true],
        '2307' => [0.01, true],
        '5507' => [0.0125, true],
        '7007' => [0.01, true],
        '6804' => [0.01, true],
        '2509' => [0.005, true],
        '3304' => [0.0175, true],
        '3305' => [0.01, true],
        '4604' => [0.0175, true],
        '7507' => [0.0075, true],
        '7406' => [0.01, true],
        '7008' => [0.01, true],
        '3905' => [0.0125, true],
        '1205' => [0.01, true],
        '4510' => [0.0075, true],
        '0209' => [0.01, true],
        '5010' => [0.01, true],
        '8607' => [0.015, true],
        '2606' => [0.0075, true],
        '0909' => [0.01, true],
        '1103' => [0.015, true],
        '1906' => [0.015, true],
        '6805' => [0.015, true],
        '7106' => [0.005, true],
        '1510' => [0.005, true],
        '8803' => [0.0125, true],
        '3306' => [0.005, true],
        '5713' => [0.0125, true],
        '8104' => [0.01, true],
        '3208' => [0.01, true],
        '1907' => [0.01, true],
        '0605' => [0.0075, true],
        '6303' => [0.0125, true],
        '0606' => [0.01, true],
        '4715' => [0.01, true],
        '1105' => [0.0175, true],
        '3906' => [0.0125, true],
        '1404' => [0.01, true],
        '3122' => [0.0125, true],
        '2906' => [0.005, true],
        '2907' => [0.01, true],
        '0502' => [0.01, false],
        '2801' => [0.01, false],
        '2302' => [0.02, false],
        '5501' => [0.0075, false],
        '7502' => [0.0125, false],
        '5901' => [0.0075, false],
        '5401' => [0.0075, false],
        '8501' => [0.01, false],
        '6501' => [0.0075, false],
        '7001' => [0.01, false],
        '5204' => [0.0125, false],
        '7201' => [0.01, false],
        '1704' => [0.0025, false],
        '8702' => [0.01, false],
        '8603' => [0.01, false],
        '5101' => [0.0075, false],
        '7203' => [0.0075, false],
        '3603' => [0.0125, false],
        '0302' => [0.0125, false],
        '7403' => [0.005, false],
        '7506' => [0.015, false],
        '4901' => [0.01, false],
        '4902' => [0.0125, false],
        '2305' => [0.015, false],
        '6502' => [0.01, false],
        '5504' => [0.0175, false],
        '5505' => [0.0125, false],
        '3902' => [0.015, false],
        '8605' => [0.0125, false],
        '8705' => [0.0125, false],
        '4508' => [0.01, false],
        '1203' => [0.01, false],
        '7612' => [0.01, false],
        '1204' => [0.01, false],
        '8706' => [0.0025, false],
        '8504' => [0.0075, false],
        '0908' => [0.0075, false],
        '5008' => [0.01, false],
        '3118' => [0.0075, false],
        '6503' => [0.015, false],
        '6806' => [0.01, false],
        '8509' => [0.0075, false],
        '5509' => [0.015, false],
        '2308' => [0.0175, false],
        '3907' => [0.0075, false],
        '7107' => [0.0075, false],
    ];

    public function compute(Collection $tax_areas)
    {
        if ($this->tax_information->exempt) {
            return 0.0;
        }

        if (!$this->checkSchoolDistrictId($this->tax_information->school_district_id) && is_null($this->tax_information->school_district_id)) {
            return 0.0;
        }

        if ($this->has_traditional_wage_base) {
            return round((($this->getGrossEarnings() - $this->getDependentAllowance()) * $this->tax_rate) / $this->payroll->pay_periods, 2);
        }

        return round($this->payroll->getEarnings() * $this->tax_rate, 2);
    }

    private function checkSchoolDistrictId($id)
    {
        if (array_key_exists($id, static::TRADITIONAL_TAX_BASE_SCHOOL_ID)) {
            $this->tax_rate = static::TRADITIONAL_TAX_BASE_SCHOOL_ID[$id][0];
            if (static::TRADITIONAL_TAX_BASE_SCHOOL_ID[$id][1]) {
                $this->has_traditional_wage_base = true;
            }
            return true;
        }
        return false;
    }

    public function getDependentAllowance()
    {
        return $this->tax_information->dependents * 650;
    }

    private function getGrossEarnings()
    {
        return ($this->payroll->getEarnings() - $this->payroll->getSupplementalEarnings()) * $this->payroll->pay_periods;
    }
}
