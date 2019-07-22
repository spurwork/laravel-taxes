<?php

namespace Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTax\V20190101;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTax\OhioSchoolDistrictTax as BaseOhioSchoolDistrictTax;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

class OhioSchoolDistrictTax extends BaseOhioSchoolDistrictTax
{
    use HasWageBase;

    protected $tax_rate;
    protected $has_wage_base;

    const WAGE_BASE = 9500;

    const TRADITIONAL_TAX_BASE_SCHOOL_ID = [
        '3301' => [0.015, false],
        '7501' => [0.015, false],
        '1901' => [0.0175, false],
        '6301' => [0.015, false],
        '3201' => [0.01, false],
        '1902' => [0.015, false],
        '3202' => [0.0125, false],
        '2001' => [0.01, false],
        '3901' => [0.005, false],
        '2501' => [0.0075, false],
        '2101' => [0.0075, false],
        '2303' => [0.0125, false],
        '0203' => [0.005, false],
        '8701' => [0.005, false],
        '5502' => [0.0175, false],
        '8601' => [0.01, false],
        '1701' => [0.015, false],
        '2102' => [0.01, false],
        '2502' => [0.0075, false],
        '8801' => [0.01, false],
        '8301' => [0.01, false],
        '2902' => [0.0125, false],
        '4201' => [0.0075, false],
        '2002' => [0.0075, false],
        '1303' => [0.01, false],
        '5402' => [0.005, false],
        '1703' => [0.0125, false],
        '1502' => [0.01, false],
        '6901' => [0.01, false],
        '6902' => [0.01, false],
        '3203' => [0.0175, false],
        '5503' => [0.02, false],
        '1503' => [0.01, false],
        '8101' => [0.01, false],
        '8502' => [0.0075, false],
        '4202' => [0.015, false],
        '2003' => [0.005, false],
        '6803' => [0.015, false],
        '8602' => [0.01, false],
        '8703' => [0.0125, false],
        '2602' => [0.0175, false],
        '8001' => [0.01, false],
        '2903' => [0.005, false],
        '2304' => [0.02, false],
        '7503' => [0.0075, false],
        '7504' => [0.015, false],
        '5406' => [0.015, false],
        '1903' => [0.0075, false],
        '7202' => [0.0125, false],
        '2603' => [0.01, false],
        '1305' => [0.01, false],
        '2904' => [0.01, false],
        '1904' => [0.005, false],
        '7505' => [0.0075, false],
        '3302' => [0.0175, false],
        '2004' => [0.0075, false],
        '5902' => [0.005, false],
        '3604' => [0.01, false],
        '3501' => [0.015, false],
        '6903' => [0.0075, false],
        '4503' => [0.01, false],
        '6904' => [0.01, false],
        '3303' => [0.01, false],
        '7204' => [0.015, false],
        '6905' => [0.0075, false],
        '3205' => [0.0075, false],
        '3502' => [0.0175, false],
        '2306' => [0.0175, false],
        '4506' => [0.01, false],
        '4903' => [0.01, false],
        '0303' => [0.0125, false],
        '0905' => [0.005, false],
        '3206' => [0.015, false],
        '1102' => [0.015, false],
        '8604' => [0.01, false],
        '6906' => [0.0125, false],
        '0601' => [0.01, false],
        '1905' => [0.0175, false],
        '8802' => [0.01, false],
        '5903' => [0.0075, false],
        '6802' => [0.0175, false],
        '0602' => [0.01, false],
        '0603' => [0.0125, false],
        '5708' => [0.0125, false],
        '3903' => [0.01, false],
        '0907' => [0.01, false],
        '7404' => [0.015, false],
        '4507' => [0.01, false],
        '5506' => [0.0175, false],
        '8003' => [0.01, false],
        '5904' => [0.01, false],
        '8505' => [0.0125, false],
        '3904' => [0.005, false],
        '4712' => [0.02, false],
        '7405' => [0.01, false],
        '8707' => [0.01, false],
        '6907' => [0.005, false],
        '6908' => [0.0075, false],
        '6909' => [0.0175, false],
        '5405' => [0.01, false],
        '3504' => [0.0175, false],
        '6302' => [0.01, false],
        '8708' => [0.005, false],
        '2604' => [0.01, false],
        '2307' => [0.01, false],
        '5507' => [0.0125, false],
        '7007' => [0.01, false],
        '6804' => [0.01, false],
        '2509' => [0.005, false],
        '3304' => [0.0175, false],
        '3305' => [0.01, false],
        '4604' => [0.0175, false],
        '7507' => [0.0075, false],
        '7406' => [0.01, false],
        '7008' => [0.01, false],
        '3905' => [0.0125, false],
        '1205' => [0.01, false],
        '4510' => [0.0075, false],
        '0209' => [0.01, false],
        '5010' => [0.01, false],
        '8607' => [0.015, false],
        '2606' => [0.0075, false],
        '0909' => [0.01, false],
        '1103' => [0.015, false],
        '1906' => [0.015, false],
        '6805' => [0.015, false],
        '7106' => [0.005, false],
        '1510' => [0.005, false],
        '8803' => [0.0125, false],
        '3306' => [0.005, false],
        '5713' => [0.0125, false],
        '8104' => [0.01, false],
        '3208' => [0.01, false],
        '1907' => [0.01, false],
        '0605' => [0.0075, false],
        '6303' => [0.0125, false],
        '0606' => [0.01, false],
        '4715' => [0.01, false],
        '1105' => [0.0175, false],
        '3906' => [0.0125, false],
        '1404' => [0.01, false],
        '3122' => [0.0125, false],
        '2906' => [0.005, false],
        '2907' => [0.01, false],
        '0502' => [0.01, true],
        '2801' => [0.01, true],
        '2302' => [0.02, true],
        '5501' => [0.0075, true],
        '7502' => [0.0125, true],
        '5901' => [0.0075, true],
        '5401' => [0.0075, true],
        '8501' => [0.01, true],
        '6501' => [0.0075, true],
        '7001' => [0.01, true],
        '5204' => [0.0125, true],
        '7201' => [0.01, true],
        '1704' => [0.0025, true],
        '8702' => [0.01, true],
        '8603' => [0.01, true],
        '5101' => [0.0075, true],
        '7203' => [0.0075, true],
        '3603' => [0.0125, true],
        '0302' => [0.0125, true],
        '7403' => [0.005, true],
        '7506' => [0.015, true],
        '4901' => [0.01, true],
        '4902' => [0.0125, true],
        '2305' => [0.015, true],
        '6502' => [0.01, true],
        '5504' => [0.0175, true],
        '5505' => [0.0125, true],
        '3902' => [0.015, true],
        '8605' => [0.0125, true],
        '8705' => [0.0125, true],
        '4508' => [0.01, true],
        '1203' => [0.01, true],
        '7612' => [0.01, true],
        '1204' => [0.01, true],
        '8706' => [0.0025, true],
        '8504' => [0.0075, true],
        '0908' => [0.0075, true],
        '5008' => [0.01, true],
        '3118' => [0.0075, true],
        '6503' => [0.015, true],
        '6806' => [0.01, true],
        '8509' => [0.0075, true],
        '5509' => [0.015, true],
        '2308' => [0.0175, true],
        '3907' => [0.0075, true],
        '7107' => [0.0075, true],
    ];

    public function compute(Collection $tax_areas)
    {
        if (!$this->checkSchoolDistrictId($this->tax_information->school_district_id) && is_null($this->tax_information->school_district_id)) {
            return;
        }

        if ($this->has_wage_base) {
            return round($this->getAdjustedEarnings() * $this->tax_rate, 2);
        }

        return round($this->payroll->getEarnings() * $this->tax_rate, 2);
    }

    public function getAdjustedEarnings()
    {
        return min($this->payroll->getEarnings(), $this->getBaseEarnings());
    }

    private function checkSchoolDistrictId($id)
    {
        if (array_key_exists($id, static::TRADITIONAL_TAX_BASE_SCHOOL_ID)) {
            $this->tax_rate = static::TRADITIONAL_TAX_BASE_SCHOOL_ID[$id][0];
            if (static::TRADITIONAL_TAX_BASE_SCHOOL_ID[$id][1]) {
                $this->has_wage_base = true;
            }
            return true;
        }
        return false;
    }
}
