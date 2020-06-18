<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseLocal;
use Appleton\Taxes\Models\Countries\US\Michigan\MichiganIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

abstract class MichiganCityTax extends BaseLocal
{
    public const DEFAULT_TAX_RATE = 0.005;

    protected $resident_city_only_living_and_working_with_tax = false;
    protected $resident_city_no_work_has_tax_and_works_in_different_city_with_no_tax = false;
    protected $resident_city_no_tax_primary_city_has_tax = false;
    protected $resident_city_no_work_has_tax_and_works_in_different_city_with_tax = false;
    protected $resident_city_is_primary_work_city_with_tax_works_in_different_city_with_tax = false;
    protected $resident_city_no_work_has_tax_works_in_2_other_cities_that_have_tax = false;
    protected $resident_city_no_work_no_tax_works_in_2_other_cities_that_have_tax = false;
    protected $special_city = false;

    protected $tax_information;
    protected $payroll;

    abstract protected function getCityName(): string;
    abstract protected function getExemptionAmount(): int;
    abstract protected function getResidencyTaxRate(): float;
    abstract protected function getNonresidencyTaxRate(): float;

    public function __construct(MichiganIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
        $this->getCityStatus();
    }

    public function doesApply(Collection $tax_areas): bool
    {
        return $this->tax_information->resident_city === $this->getCityName()
            || $this->tax_information->primary_nonresident_city === $this->getCityName()
            || $this->tax_information->secondary_nonresident_city === $this->getCityName();
    }

    // pass in the resident or non resident total
    public function getExemptionAmountTotal($number_of_exemptions): int
    {
        return $this->getExemptionAmount() * $number_of_exemptions;
    }

    public function compute(Collection $tax_areas)
    {
        if ($this->tax_information->exempt) {
            return 0.0;
        }

        // Resident living and working in city that levies tax and resident living in a city that levies a tax and works in another city w/o tax
        if ($this->tax_information->resident_city === $this->getCityName()
            && ($this->resident_city_only_living_and_working_with_tax || $this->resident_city_no_work_has_tax_and_works_in_different_city_with_no_tax)) {
            return round(($this->payroll->getEarnings() - ($this->getExemptionAmountTotal($this->tax_information->resident_exemptions) / $this->payroll->pay_periods)) * $this->getResidencyTaxRate(), 2);

        // nonresident working in a city that levies the local tax but does not live in a city that levies a local tax
        } elseif ($this->tax_information->primary_nonresident_city === $this->getCityName() && $this->resident_city_no_tax_primary_city_has_tax) {
            return round(($this->payroll->getEarnings() - ($this->getExemptionAmountTotal($this->tax_information->nonresident_exemptions) / $this->payroll->pay_periods)) * $this->getNonresidencyTaxRate(), 2);

        // resident living in a city that levies a tax and works in another city that levies a tax not special rates
        } elseif ($this->tax_information->resident_city === $this->getCityName() && ($this->resident_city_no_work_has_tax_and_works_in_different_city_with_tax)) {
            return round(($this->payroll->getEarnings() - ($this->getExemptionAmountTotal($this->tax_information->resident_exemptions) / $this->payroll->pay_periods)) * self::DEFAULT_TAX_RATE, 2);
        } elseif ($this->tax_information->primary_nonresident_city === $this->getCityName() && $this->resident_city_no_work_has_tax_and_works_in_different_city_with_tax) {
            return round(($this->payroll->getEarnings() - ($this->getExemptionAmountTotal($this->tax_information->nonresident_exemptions) / $this->payroll->pay_periods)) * self::DEFAULT_TAX_RATE, 2);

        // resident living in a city that levies a tax and works in another city that levies a tax with special rates
        } elseif ($this->tax_information->resident_city === $this->getCityName() && ($this->resident_city_no_work_has_tax_and_works_in_different_city_with_tax)) {
            return round(($this->payroll->getEarnings() - ($this->getExemptionAmountTotal($this->tax_information->resident_exemptions) / $this->payroll->pay_periods)) * $this->getSpecialCityRate($this->tax_information->resident_city, $this->tax_information->primary_nonresident_city, true), 2);
        } elseif ($this->tax_information->primary_nonresident_city === $this->getCityName() && $this->resident_city_no_work_has_tax_and_works_in_different_city_with_tax) {
            return round(($this->payroll->getEarnings() - ($this->getExemptionAmountTotal($this->tax_information->nonresident_exemptions) / $this->payroll->pay_periods)) * $this->getSpecialCityRate($this->tax_information->resident_city, $this->tax_information->primary_nonresident_city, false), 2);

        // Lives AND works in a city that levies a tax AND works in another city that levies a tax no special rates
        } elseif ($this->tax_information->resident_city === $this->getCityName() && ($this->resident_city_is_primary_work_city_with_tax_works_in_different_city_with_tax)) {
            return round(($this->payroll->getEarnings() - ($this->getExemptionAmountTotal($this->tax_information->resident_exemptions) / $this->payroll->pay_periods)) * self::DEFAULT_TAX_RATE, 2);
        } elseif ($this->tax_information->secondary_nonresident_city === $this->getCityName() && $this->resident_city_is_primary_work_city_with_tax_works_in_different_city_with_tax) {
            return round(($this->payroll->getEarnings() * $this->tax_information->secondary_nonresident_city_percentage_worked - ($this->getExemptionAmountTotal($this->tax_information->nonresident_exemptions) / $this->payroll->pay_periods)) * self::DEFAULT_TAX_RATE, 2);

        // Lives AND works in a city that levies a tax AND works in another city that levies a tax with special rates
        } elseif ($this->tax_information->resident_city === $this->getCityName() && ($this->resident_city_is_primary_work_city_with_tax_works_in_different_city_with_tax)) {
            return round(($this->payroll->getEarnings() - ($this->getExemptionAmountTotal($this->tax_information->resident_exemptions) / $this->payroll->pay_periods)) * $this->getSpecialCityRate($this->tax_information->resident_city, $this->tax_information->secondary_nonresident_city, true), 2);
        } elseif ($this->tax_information->secondary_nonresident_city === $this->getCityName() && $this->resident_city_is_primary_work_city_with_tax_works_in_different_city_with_tax) {
            return round(($this->payroll->getEarnings() * $this->tax_information->secondary_nonresident_city_percentage_worked - ($this->getExemptionAmountTotal($this->tax_information->nonresident_exemptions) / $this->payroll->pay_periods)) * $this->getSpecialCityRate($this->tax_information->resident_city, $this->tax_information->secondary_nonresident_city, false), 2);

        // Lives in a city that levies a tax AND works in 2 other cities that both levy a tax no special rates
        } elseif ($this->tax_information->resident_city === $this->getCityName() && ($this->resident_city_no_work_has_tax_works_in_2_other_cities_that_have_tax)) {
            return round(($this->payroll->getEarnings() - ($this->getExemptionAmountTotal($this->tax_information->resident_exemptions) / $this->payroll->pay_periods)) * self::DEFAULT_TAX_RATE, 2);
        } elseif ($this->tax_information->primary_nonresident_city === $this->getCityName() && $this->resident_city_no_work_has_tax_works_in_2_other_cities_that_have_tax) {
            if ($this->tax_information->primary_nonresident_city_percentage_worked >= $this->tax_information->secondary_nonresident_city_percentage_worked) {
                return round(($this->payroll->getEarnings() * $this->tax_information->primary_nonresident_city_percentage_worked - ($this->getExemptionAmountTotal($this->tax_information->nonresident_exemptions) / $this->payroll->pay_periods)) * self::DEFAULT_TAX_RATE, 2);
            }
        } elseif ($this->tax_information->secondary_nonresident_city === $this->getCityName() && $this->resident_city_no_work_has_tax_works_in_2_other_cities_that_have_tax) {
            if ($this->tax_information->secondary_nonresident_city_percentage_worked > $this->tax_information->primary_nonresident_city_percentage_worked) {
                return round(($this->payroll->getEarnings() * $this->tax_information->secondary_nonresident_city_percentage_worked - ($this->getExemptionAmountTotal($this->tax_information->nonresident_exemptions) / $this->payroll->pay_periods)) * self::DEFAULT_TAX_RATE, 2);
            }

            // Lives in a city that levies a tax AND works in 2 other cities that both levy a tax with special rates
        } elseif ($this->tax_information->resident_city === $this->getCityName() && ($this->resident_city_no_work_has_tax_works_in_2_other_cities_that_have_tax)) {
            return round(($this->payroll->getEarnings() - ($this->getExemptionAmountTotal($this->tax_information->resident_exemptions) / $this->payroll->pay_periods)) * $this->getSpecialCityRate($this->tax_information->resident_city, $this->tax_information->secondary_nonresident_city, true), 2);
        } elseif ($this->tax_information->primary_nonresident_city === $this->getCityName() && $this->resident_city_no_work_has_tax_works_in_2_other_cities_that_have_tax) {
            if ($this->tax_information->primary_nonresident_city_percentage_worked >= $this->tax_information->secondary_nonresident_city_percentage_worked) {
                return round(($this->payroll->getEarnings() * $this->tax_information->primary_nonresident_city_percentage_worked - ($this->getExemptionAmountTotal($this->tax_information->nonresident_exemptions) / $this->payroll->pay_periods)) * $this->getSpecialCityRate($this->tax_information->resident_city, $this->tax_information->primary_nonresident_city, false), 2);
            }
        } elseif ($this->tax_information->secondary_nonresident_city === $this->getCityName() && $this->resident_city_no_work_has_tax_works_in_2_other_cities_that_have_tax) {
            if ($this->tax_information->secondary_nonresident_city_percentage_worked > $this->tax_information->primary_nonresident_city_percentage_worked) {
                return round(($this->payroll->getEarnings() * $this->tax_information->secondary_nonresident_city_percentage_worked - ($this->getExemptionAmountTotal($this->tax_information->nonresident_exemptions) / $this->payroll->pay_periods)) * $this->getSpecialCityRate($this->tax_information->resident_city, $this->tax_information->secondary_nonresident_city, false), 2);
            }

            // Lives in a city that with no tax AND works in 2 other cities that both levy a tax no special rates
        } elseif ($this->tax_information->primary_nonresident_city === $this->getCityName() && $this->resident_city_no_work_no_tax_works_in_2_other_cities_that_have_tax) {
            return round(($this->payroll->getEarnings() * $this->tax_information->primary_nonresident_city_percentage_worked - ($this->getExemptionAmountTotal($this->tax_information->nonresident_exemptions) / $this->payroll->pay_periods)) * self::DEFAULT_TAX_RATE, 2);
        } elseif ($this->tax_information->secondary_nonresident_city === $this->getCityName() && $this->resident_city_no_work_no_tax_works_in_2_other_cities_that_have_tax) {
            return round(($this->payroll->getEarnings() * $this->tax_information->secondary_nonresident_city_percentage_worked - ($this->getExemptionAmountTotal($this->tax_information->nonresident_exemptions) / $this->payroll->pay_periods)) * self::DEFAULT_TAX_RATE, 2);

        // Lives in a city that with no tax AND works in 2 other cities that both levy a tax with special rates
        } elseif ($this->tax_information->primary_nonresident_city === $this->getCityName() && $this->resident_city_no_work_no_tax_works_in_2_other_cities_that_have_tax) {
            return round(($this->payroll->getEarnings() * $this->tax_information->primary_nonresident_city_percentage_worked - ($this->getExemptionAmountTotal($this->tax_information->nonresident_exemptions) / $this->payroll->pay_periods)) * $this->getSpecialCityRate($this->tax_information->primary_nonresident_city, $this->tax_information->secondary_nonresident_city, false), 2);
        } elseif ($this->tax_information->secondary_nonresident_city === $this->getCityName() && $this->resident_city_no_work_no_tax_works_in_2_other_cities_that_have_tax) {
            return round(($this->payroll->getEarnings() * $this->tax_information->secondary_nonresident_city_percentage_worked - ($this->getExemptionAmountTotal($this->tax_information->nonresident_exemptions) / $this->payroll->pay_periods)) * $this->getSpecialCityRate($this->tax_information->primary_nonresident_city, $this->tax_information->secondary_nonresident_city, false), 2);
        }
    }

    public function specialCityRate($resident_city, $work_city, $is_resident_city)
    {
        $resident_city_resident_rate = 0;
        $resident_city_nonresident_rate = 0;
        $work_city_nonresident_rate = 0;
        // detroit r = .024 n = .012
        // GrandRapids r = .015 n = .0075
        // HighlandPark r = .02 n = .01
        // Saginaw r = .015 n = .0075
        if ($resident_city === 'Detroit') {
            $resident_city_resident_rate = 0.024;
            $resident_city_nonresident_rate = 0.012;
        } elseif ($resident_city === 'GrandRapids' || $resident_city === 'Saginaw') {
            $resident_city_resident_rate = 0.015;
            $resident_city_nonresident_rate = 0.0075;
        } elseif ($resident_city === 'HighlandPark') {
            $resident_city_resident_rate = 0.02;
            $resident_city_nonresident_rate = 0.01;
        }

        if ($work_city === 'Detroit') {
            $work_city_nonresident_rate = 0.012;
        } elseif ($work_city === 'GrandRapids' || $work_city === 'Saginaw') {
            $work_city_nonresident_rate = 0.0075;
        } elseif ($work_city === 'HighlandPark') {
            $work_city_nonresident_rate = 0.01;
        }

        if ($work_city_nonresident_rate < $resident_city_nonresident_rate) {
            if ($is_resident_city) {
                return $resident_city_resident_rate - $work_city_nonresident_rate;
            } else {
                return $work_city_nonresident_rate;
            }
        } else {
            if ($is_resident_city) {
                return $resident_city_nonresident_rate;
            } else {
                return $work_city_nonresident_rate;
            }
        }
    }

    protected function getCityStatus()
    {
        // Resident living and working in city that levies tax
        if ($this->tax_information->resident_city !== ''
            && $this->tax_information->primary_nonresident_city !== ''
            && $this->tax_information->resident_city === $this->tax_information->primary_nonresident_city
            && $this->tax_information->secondary_nonresident_city === '') {
            $this->resident_city_only_living_and_working_with_tax = true;
        // resident living in a city that levies a tax and works in another city
        } elseif ($this->tax_information->resident_city !== ''
            && $this->tax_information->primary_nonresident_city === ''
            && $this->tax_information->secondary_nonresident_city === '') {
            $this->resident_city_no_work_has_tax_and_works_in_different_city_with_no_tax = true;
        // nonresident working in a city that levies the local tax but does not live in a city that levies a local tax
        } elseif ($this->tax_information->resident_city === ''
            && $this->tax_information->primary_nonresident_city !== ''
            && $this->tax_information->secondary_nonresident_city === '') {
            $this->resident_city_no_tax_primary_city_has_tax = true;
        // resident living in a city that levies a tax and works in another city that levies a tax
        } elseif ($this->tax_information->resident_city !== ''
            && $this->tax_information->primary_nonresident_city !== ''
            && $this->tax_information->resident_city !== $this->tax_information->primary_nonresident_city
            && $this->tax_information->secondary_nonresident_city === '') {
            $this->resident_city_no_work_has_tax_and_works_in_different_city_with_tax = true;
        // lives AND works in a city that levies a tax AND works in another city that levies a tax
        } elseif ($this->tax_information->resident_city !== ''
            && $this->tax_information->primary_nonresident_city !== ''
            && $this->tax_information->resident_city === $this->tax_information->primary_nonresident_city
            && $this->tax_information->secondary_nonresident_city !== '') {
            $this->resident_city_is_primary_work_city_with_tax_works_in_different_city_with_tax = true;
        // Lives in a city that levies a tax AND works in 2 other cities that both levy a tax
        } elseif ($this->tax_information->resident_city !== ''
            && $this->tax_information->primary_nonresident_city !== ''
            && $this->tax_information->secondary_nonresident_city !== ''
            && $this->tax_information->primary_nonresident_city !== $this->tax_information->secondary_nonresident_city) {
            $this->resident_city_no_work_has_tax_works_in_2_other_cities_that_have_tax = true;
        // Lives in a city with no tax AND works in 2 other cities that both levy a tax
        } elseif ($this->tax_information->resident_city === ''
            && $this->tax_information->primary_nonresident_city !== ''
            && $this->tax_information->secondary_nonresident_city !== ''
            && $this->tax_information->primary_nonresident_city !== $this->tax_information->secondary_nonresident_city) {
            $this->resident_city_no_work_no_tax_works_in_2_other_cities_that_have_tax = true;
        }
    }
}
